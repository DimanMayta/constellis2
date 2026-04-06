<?php

namespace App\Http\Controllers;

use App\Models\StoreCategory;
use App\Models\StoreProduct;
use App\Models\StoreOrder;
use Illuminate\Http\Request;

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

        if (auth()->attempt($request->only('email', 'password'))) {
            if (auth()->user()->canAccessStore()) {
                return redirect()->route('store.index');
            }
            auth()->logout();
            return back()->withErrors(['email' => 'Your account does not have store access.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function index(Request $request)
    {
        $categories = StoreCategory::active()->ordered()->get();
        $query = StoreProduct::active()->ordered()->with('category');

        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        $products = $query->paginate(12);
        return view('pages.store.index', compact('categories', 'products'));
    }

    public function show(StoreProduct $product)
    {
        $related = StoreProduct::active()
            ->where('store_category_id', $product->store_category_id)
            ->where('id', '!=', $product->id)
            ->take(4)->get();

        return view('pages.store.show', compact('product', 'related'));
    }

    public function cart()
    {
        $cart = session('cart', []);
        $products = [];
        $total = 0;

        foreach ($cart as $id => $item) {
            $product = StoreProduct::find($id);
            if ($product) {
                $products[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'size' => $item['size'] ?? null,
                    'color' => $item['color'] ?? null,
                    'subtotal' => $product->price * $item['quantity'],
                ];
                $total += $product->price * $item['quantity'];
            }
        }

        return view('pages.store.cart', compact('products', 'total'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:store_products,id',
            'quantity' => 'required|integer|min:1|max:10',
            'size' => 'nullable|string',
            'color' => 'nullable|string',
        ]);

        $cart = session('cart', []);
        $id = $request->product_id;

        if (isset($cart[$id])) {
            $cart[$id]['quantity'] += $request->quantity;
        } else {
            $cart[$id] = [
                'quantity' => $request->quantity,
                'size' => $request->size,
                'color' => $request->color,
            ];
        }

        session(['cart' => $cart]);

        if ($request->wantsJson()) {
            return response()->json(['message' => 'Added to cart', 'count' => count($cart)]);
        }

        return back()->with('success', 'Product added to cart.');
    }

    public function removeFromCart(Request $request)
    {
        $cart = session('cart', []);
        unset($cart[$request->product_id]);
        session(['cart' => $cart]);

        return back()->with('success', 'Product removed from cart.');
    }

    public function checkout(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('store.cart')->with('error', 'Your cart is empty.');
        }

        if ($request->isMethod('get')) {
            // Show checkout form
            $items = [];
            $total = 0;
            foreach ($cart as $id => $item) {
                $product = StoreProduct::find($id);
                if ($product) {
                    $items[] = ['product' => $product, 'quantity' => $item['quantity']];
                    $total += $product->price * $item['quantity'];
                }
            }
            return view('pages.store.checkout', compact('items', 'total'));
        }

        // Process order
        $request->validate([
            'shipping_address' => 'required|string|max:500',
            'notes' => 'nullable|string|max:1000',
        ]);

        $items = [];
        $total = 0;
        foreach ($cart as $id => $item) {
            $product = StoreProduct::find($id);
            if ($product) {
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
        }

        $order = StoreOrder::create([
            'order_number' => StoreOrder::generateOrderNumber(),
            'user_id' => auth()->id(),
            'items' => $items,
            'subtotal' => $total,
            'tax' => round($total * 0.08, 2),
            'total' => round($total * 1.08, 2),
            'status' => 'pending',
            'shipping_address' => $request->shipping_address,
            'notes' => $request->notes,
        ]);

        session()->forget('cart');

        return redirect()->route('store.index')
            ->with('success', 'Order #' . $order->order_number . ' placed successfully!');
    }
}
