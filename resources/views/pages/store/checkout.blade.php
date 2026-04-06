@extends('layouts.app')
@section('title', 'Checkout — Constellis Store')

@section('content')
<section class="py-8 bg-white -mt-20 pt-28">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-3xl font-display font-bold text-slate-900 mb-8">Checkout</h1>

        <div class="grid gap-8">
            <div class="card p-6">
                <h2 class="font-display font-semibold text-slate-900 mb-4">Order Summary</h2>
                <div class="space-y-3">
                    @foreach($items as $item)
                        <div class="flex justify-between items-center py-2 border-b border-slate-50 last:border-0">
                            <div><p class="text-slate-900 font-medium text-sm">{{ $item['product']->name }}</p><p class="text-slate-400 text-xs">Qty: {{ $item['quantity'] }}</p></div>
                            <span class="text-slate-900 font-semibold text-sm">${{ number_format($item['product']->price * $item['quantity'], 2) }}</span>
                        </div>
                    @endforeach
                </div>
                <div class="border-t border-slate-100 mt-4 pt-4">
                    <div class="flex justify-between"><span class="text-slate-500 text-sm">Subtotal</span><span class="font-semibold">${{ number_format($total, 2) }}</span></div>
                    <div class="flex justify-between mt-1"><span class="text-slate-500 text-sm">Tax</span><span class="font-semibold">${{ number_format($total * 0.08, 2) }}</span></div>
                    <div class="flex justify-between mt-2 text-lg"><span class="font-display font-bold">Total</span><span class="font-display font-bold">${{ number_format($total * 1.08, 2) }}</span></div>
                </div>
            </div>

            <form action="{{ route('store.checkout.process') }}" method="POST" class="card p-8 space-y-6">
                @csrf
                <div>
                    <label for="shipping_address" class="block text-slate-700 text-sm font-semibold mb-2">Shipping Address *</label>
                    <textarea id="shipping_address" name="shipping_address" rows="3" required
                              class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none" placeholder="Enter your shipping address...">{{ old('shipping_address') }}</textarea>
                    @error('shipping_address') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="notes" class="block text-slate-700 text-sm font-semibold mb-2">Order Notes</label>
                    <textarea id="notes" name="notes" rows="2"
                              class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none" placeholder="Any special instructions...">{{ old('notes') }}</textarea>
                </div>
                <div class="p-4 rounded-xl bg-amber-50 border border-amber-200">
                    <p class="text-amber-800 text-sm"><strong>Note:</strong> Payment processing is not yet enabled. Orders will be tracked and fulfilled through internal channels.</p>
                </div>
                <button type="submit" class="btn-primary w-full py-4 text-base">Place Order</button>
            </form>
        </div>
    </div>
</section>
@endsection
