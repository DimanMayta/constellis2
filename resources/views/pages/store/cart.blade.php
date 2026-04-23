@extends('layouts.app')
@section('title', 'Cart — Constellis Store')

@section('content')
<section class="py-8 bg-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('store.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Continue Shopping
        </a>

        <h1 class="text-3xl font-display font-bold text-slate-900 mb-8">Your Cart</h1>

        @if(count($products) === 0)
            <div class="text-center py-20 card p-10">
                <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17"/></svg>
                <p class="text-slate-400 text-lg mb-4">Your cart is empty</p>
                <a href="{{ route('store.index') }}" class="btn-primary">Browse Store</a>
            </div>
        @else
            <div class="space-y-4 mb-8">
                @foreach($products as $item)
                    <div class="card p-6 flex items-center gap-6">
                        <div class="w-20 h-20 rounded-xl shrink-0 relative overflow-hidden bg-slate-100">
                            @if($item['product']->images && count($item['product']->images) > 0)
                                <img src="{{ asset('storage/' . $item['product']->images[0]) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                            @else
                                <div class="absolute inset-0 flex items-center justify-center img-placeholder"><span class="text-white/30 font-bold text-xs">{{ substr($item['product']->name, 0, 2) }}</span></div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <h3 class="text-slate-900 font-semibold truncate">{{ $item['product']->name }}</h3>
                            <p class="text-slate-400 text-sm">Qty: {{ $item['quantity'] }}{{ $item['size'] ? ' · ' . $item['size'] : '' }}{{ $item['color'] ? ' · ' . $item['color'] : '' }}</p>
                        </div>
                        <p class="text-slate-900 font-display font-bold text-lg">${{ number_format($item['subtotal'], 2) }}</p>
                        <form action="{{ route('store.cart.remove') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $item['product']->id }}">
                            <button type="submit" class="w-8 h-8 rounded-lg text-slate-400 hover:text-red-600 hover:bg-red-50 flex items-center justify-center transition-all">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="card p-8">
                <div class="flex justify-between items-center mb-2"><span class="text-slate-500">Subtotal</span><span class="text-slate-900 font-semibold">${{ number_format($total, 2) }}</span></div>
                <div class="flex justify-between items-center mb-2"><span class="text-slate-500">Tax (8%)</span><span class="text-slate-900 font-semibold">${{ number_format($total * 0.08, 2) }}</span></div>
                <div class="border-t border-slate-100 my-4"></div>
                <div class="flex justify-between items-center"><span class="text-slate-900 font-display font-bold text-xl">Total</span><span class="text-slate-900 font-display font-bold text-2xl">${{ number_format($total * 1.08, 2) }}</span></div>
                <a href="{{ route('store.checkout') }}" class="btn-primary w-full mt-6 py-4 text-base">Proceed to Checkout</a>
            </div>
        @endif
    </div>
</section>
@endsection
