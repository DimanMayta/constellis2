@extends('layouts.app')
@section('title', 'Constellis Store')

@section('content')
<section class="relative py-16 overflow-hidden bg-gradient-to-br from-slate-800 via-slate-900 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-10"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <span class="text-blue-300 text-sm font-bold tracking-wider uppercase mb-2 block">Employee Exclusive</span>
                <h1 class="text-3xl font-display font-bold text-white">Constellis Store</h1>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('store.cart') }}" class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white/10 border border-white/20 text-white text-sm font-medium hover:bg-white/20 transition-all">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 100 4 2 2 0 000-4z"/></svg>
                    Cart
                    @if(count(session('cart', [])) > 0)
                        <span class="absolute -top-1 -right-1 w-5 h-5 rounded-full bg-blue-500 text-white text-xs flex items-center justify-center">{{ count(session('cart', [])) }}</span>
                    @endif
                </a>
                <span class="text-slate-400 text-sm">Welcome, {{ auth()->user()->name }}</span>
            </div>
        </div>
    </div>
</section>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6">
        <div class="card p-4 border-green-200 bg-green-50"><p class="text-green-800 text-sm font-medium">{{ session('success') }}</p></div>
    </div>
@endif

<section class="py-12 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Categories filter --}}
        <div class="flex flex-wrap gap-2 mb-10">
            <a href="{{ route('store.index') }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">All</a>
            @foreach($categories as $cat)
                <a href="{{ route('store.index', ['category' => $cat->slug]) }}" class="px-5 py-2 rounded-full text-sm font-medium transition-all {{ request('category') === $cat->slug ? 'bg-blue-600 text-white' : 'bg-slate-100 text-slate-600 hover:bg-blue-50 hover:text-blue-700' }}">{{ $cat->name }}</a>
            @endforeach
        </div>

        {{-- Products Grid --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <div class="card overflow-hidden group">
                    <div class="aspect-square relative overflow-hidden bg-slate-100">
                        @if($product->images && count($product->images) > 0)
                            <img src="{{ asset('storage/' . $product->images[0]) }}"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center img-placeholder">
                                <span class="font-display font-bold text-3xl text-white/30">{{ substr($product->name, 0, 2) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="p-5">
                        <p class="text-xs text-blue-600 font-medium mb-1">{{ $product->category->name }}</p>
                        <h3 class="text-slate-900 font-display font-semibold text-base mb-1 group-hover:text-blue-600 transition-colors">
                            <a href="{{ route('store.show', $product) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-slate-400 text-xs mb-3 line-clamp-2">{{ $product->description }}</p>
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-display font-bold text-slate-900">${{ number_format($product->price, 2) }}</span>
                            <form action="{{ route('store.cart.add') }}" method="POST">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center hover:bg-blue-700 transition-colors">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">{{ $products->links() }}</div>
    </div>
</section>
@endsection
