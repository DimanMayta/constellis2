<?php

namespace App\Http\Controllers;

use App\Models\StoreCategory;
use App\Models\StoreProduct;
use App\Models\StoreOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StoreController extends Controller
{
    public function gate()
    {
        if (auth()->check() && auth()->user()->canAccessStore()) {
            return redirect()->route('store.index');
        }
        return view('pages.store.gate');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();

        // User not found — generic error
        if (!$user) {
            return back()->withErrors(['email' => 'invalid'])->withInput($request->only('email'));
        }

        // Account is locked
        if ($user->is_locked) {
            return back()->withErrors(['email' => 'locked'])->withInput($request->only('email'));
        }

        // Try authentication
        if (auth()->attempt($request->only('email', 'password'))) {
            // Successful login — reset attempts
            $user->update(['login_attempts' => 0]);

            if (auth()->user()->canAccessStore()) {
                return redirect()->route('store.index');
            }
            auth()->logout();
            return back()->withErrors(['email' => 'no_access'])->withInput($request->only('email'));
        }

        // Failed login — increment attempts
        $user->incrementLoginAttempts();
        $remaining = $user->remaining_attempts;

        if ($remaining <= 0) {
            return back()->withErrors(['email' => 'locked'])->withInput($request->only('email'));
        }

        return back()->withErrors([
            'email' => "attempts:{$remaining}",
        ])->withInput($request->only('email'));
    }

    public function index(Request $request)
    {
        $categories = StoreCategory::active()->ordered()->get();
        $query = StoreProduct::active()->ordered()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        $products = $query->paginate(12)->withQueryString();
        $cartCount = $this->getCartItemCount();

        return view('pages.store.index', compact('categories', 'products', 'cartCount'));
    }

    public function show(StoreProduct $product)
    {
        $related = StoreProduct::active()
            ->where('store_category_id', $product->store_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)->get();

        $cartCount = $this->getCartItemCount();

        return view('pages.store.show', compact('product', 'related', 'cartCount'));
    }

    public function cart()
    {
        $cart = $this->migrateCart();
        $products = [];
        $total = 0;

        foreach ($cart as $key => $item) {
            $product = StoreProduct::find($item['product_id'] ?? null);
            if ($product) {
                $subtotal = $product->price * $item['quantity'];
                $products[] = [
                    'key' => $key,
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? null,
                    'color' => $item['color'] ?? null,
                    'subtotal' => $subtotal,
                ];
                $total += $subtotal;
            } else {
                // Clean up invalid cart items
                unset($cart[$key]);
                session(['cart' => $cart]);
            }
        }

        $cartCount = $this->getCartItemCount();

        return view('pages.store.cart', compact('products', 'total', 'cartCount'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:store_products,id',
            'quantity' => 'required|integer|min:1|max:10',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $product = StoreProduct::find($request->product_id);

        // Validate product is active
        if (!$product || !$product->is_active) {
            return back()->with('error', 'This product is not available.');
        }

        // Build composite key: product_id + size + color
        $size = $request->size ?? '';
        $color = $request->color ?? '';
        $cartKey = $product->id . '_' . $size . '_' . $color;

        $cart = $this->migrateCart();

        // Calculate total quantity for this product across all variants
        $existingQty = 0;
        foreach ($cart as $key => $item) {
            if (($item['product_id'] ?? null) == $product->id) {
                $existingQty += $item['quantity'] ?? 0;
            }
        }

        // Check if adding this quantity would exceed inventory
        $addQty = $request->quantity;
        if (isset($cart[$cartKey])) {
            $currentQty = $cart[$cartKey]['quantity'];
            if (($existingQty - $currentQty + $currentQty + $addQty) > $product->inventory) {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Not enough stock available.'], 422);
                }
                return back()->with('error', 'Not enough stock available. Only ' . $product->inventory . ' units remain.');
            }
            $cart[$cartKey]['quantity'] += $addQty;
        } else {
            if (($existingQty + $addQty) > $product->inventory) {
                if ($request->wantsJson()) {
                    return response()->json(['error' => 'Not enough stock available.'], 422);
                }
                return back()->with('error', 'Not enough stock available. Only ' . $product->inventory . ' units remain.');
            }
            $cart[$cartKey] = [
                'product_id' => $product->id,
                'quantity' => $addQty,
                'size' => $request->size,
                'color' => $request->color,
            ];
        }

        session(['cart' => $cart]);

        if ($request->wantsJson()) {
            return response()->json([
                'message' => 'Added to cart',
                'count' => $this->getCartItemCount(),
            ]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
            'quantity' => 'required|integer|min:1|max:10',
        ]);

        $cart = $this->migrateCart();

        if (!isset($cart[$request->cart_key])) {
            return back()->with('error', 'Item not found in cart.');
        }

        $item = $cart[$request->cart_key];
        $product = StoreProduct::find($item['product_id']);

        if (!$product) {
            unset($cart[$request->cart_key]);
            session(['cart' => $cart]);
            return back()->with('error', 'Product no longer available.');
        }

        // Calculate total quantity for this product across all variants (excluding current)
        $otherQty = 0;
        foreach ($cart as $key => $cartItem) {
            if (!isset($cartItem['product_id'])) continue;
            if ($key !== $request->cart_key && $cartItem['product_id'] == $product->id) {
                $otherQty += $cartItem['quantity'];
            }
        }

        if (($otherQty + $request->quantity) > $product->inventory) {
            return back()->with('error', 'Not enough stock. Only ' . $product->inventory . ' units available.');
        }

        $cart[$request->cart_key]['quantity'] = $request->quantity;
        session(['cart' => $cart]);

        return back()->with('success', 'Cart updated.');
    }

    public function removeFromCart(Request $request)
    {
        $request->validate([
            'cart_key' => 'required|string',
        ]);

        $cart = $this->migrateCart();
        unset($cart[$request->cart_key]);
        session(['cart' => $cart]);

        return back()->with('success', 'Product removed from cart.');
    }

    public function checkout(Request $request)
    {
        $cart = $this->migrateCart();
        if (empty($cart)) {
            return redirect()->route('store.cart')->with('error', 'Your cart is empty.');
        }

        if ($request->isMethod('get')) {
            // Show checkout form
            $items = [];
            $total = 0;
            foreach ($cart as $key => $item) {
                $product = StoreProduct::find($item['product_id'] ?? null);
                if ($product) {
                    $items[] = [
                        'key' => $key,
                        'product' => $product,
                        'quantity' => $item['quantity'],
                        'size' => $item['size'] ?? null,
                        'color' => $item['color'] ?? null,
                    ];
                    $total += $product->price * $item['quantity'];
                }
            }
            $cartCount = $this->getCartItemCount();
            return view('pages.store.checkout', compact('items', 'total', 'cartCount'));
        }

        // Process order using DB transaction
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            return DB::transaction(function () use ($request, $cart) {
                $items = [];
                $total = 0;

                foreach ($cart as $key => $item) {
                    $product = StoreProduct::lockForUpdate()->find($item['product_id'] ?? null);

                    if (!$product || !$product->is_active) {
                        throw new \Exception("Product is no longer available.");
                    }

                    if ($product->inventory < $item['quantity']) {
                        throw new \Exception("Insufficient stock for '{$product->name}'. Only {$product->inventory} units available.");
                    }

                    // Decrement inventory
                    $product->decrement('inventory', $item['quantity']);

                    $items[] = [
                        'product_id' => $product->id,
                        'name' => $product->name,
                        'price' => $product->price,
                        'quantity' => $item['quantity'],
                        'size' => $item['size'] ?? null,
                        'color' => $item['color'] ?? null,
                    ];
                    $total += $product->price * $item['quantity'];
                }

                $order = StoreOrder::create([
                    'order_number' => StoreOrder::generateOrderNumber(),
                    'user_id' => auth()->id(),
                    'items' => $items,
                    'subtotal' => $total,
                    'tax' => 0,
                    'total' => $total,
                    'status' => 'pending',
                    'shipping_address' => $request->shipping_address,
                    'notes' => $request->notes,
                ]);

                session()->forget('cart');

                return redirect()->route('store.index')
                    ->with('success', 'Order #' . $order->order_number . ' placed successfully!');
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function storeLogout()
    {
        auth()->logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('store.gate');
    }

    /**
     * Get total number of unique items in cart
     */
    private function getCartItemCount(): int
    {
        return count(session('cart', []));
    }

    /**
     * Migrate old cart format to new composite-key format.
     * Old format: $cart[product_id] = ['quantity' => X, 'size' => Y, 'color' => Z]
     * New format: $cart[product_id_size_color] = ['product_id' => X, 'quantity' => Y, 'size' => Z, 'color' => W]
     */
    private function migrateCart(): array
    {
        $cart = session('cart', []);
        $migrated = false;

        foreach ($cart as $key => $item) {
            // Old format detection: item doesn't have 'product_id' field
            if (!isset($item['product_id'])) {
                // In old format, the key IS the product_id
                $productId = $key;
                $size = $item['size'] ?? '';
                $color = $item['color'] ?? '';
                $newKey = $productId . '_' . $size . '_' . $color;

                // Remove old entry
                unset($cart[$key]);

                // Add in new format
                $cart[$newKey] = [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'] ?? 1,
                    'size' => $item['size'] ?? null,
                    'color' => $item['color'] ?? null,
                ];

                $migrated = true;
            }
        }

        if ($migrated) {
            session(['cart' => $cart]);
        }

        return $cart;
    }
}
