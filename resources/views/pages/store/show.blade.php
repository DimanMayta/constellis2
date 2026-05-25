@extends('layouts.app')
@section('title', $product->name . ' — NSG Store')

@section('content')
<div x-data="{
    mainImage: '{{ ($product->images && count($product->images) > 0) ? asset('storage/' . $product->images[0]) : '' }}',
    cartCount: {{ $cartCount }},
    quantity: 1,
    maxQty: {{ min(10, $product->inventory) }}
}" class="bg-slate-50 min-h-screen">

    {{-- Mini Header --}}
    <div class="bg-white border-b border-slate-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <a href="{{ route('store.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm font-medium transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span x-text="$store.lang.current === 'en' ? 'Back to Store' : 'Volver a la Tienda'"></span>
            </a>
            <a href="{{ route('store.cart') }}" class="relative inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-slate-900 text-white text-sm font-medium hover:bg-blue-600 transition-all">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                <span x-text="$store.lang.current === 'en' ? 'Cart' : 'Carrito'"></span>
                <template x-if="cartCount > 0">
                    <span class="absolute -top-1.5 -right-1.5 w-5 h-5 rounded-full bg-blue-500 text-white text-[10px] font-bold flex items-center justify-center ring-2 ring-white" x-text="cartCount"></span>
                </template>
            </a>
        </div>
    </div>

    {{-- Breadcrumb --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
        <nav class="flex items-center gap-2 text-xs text-slate-400">
            <a href="{{ route('store.index') }}" class="hover:text-slate-600 transition-colors">Store</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('store.index', ['category' => $product->category->slug]) }}" class="hover:text-slate-600 transition-colors">{{ $product->category->name }}</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-slate-600 font-medium truncate max-w-[200px]">{{ $product->name }}</span>
        </nav>
    </div>

    {{-- ══════════════════════════════════════════ --}}
    {{-- PRODUCT DETAIL --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="pb-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-10 lg:gap-16 mt-4">

                {{-- ── LEFT: Image Gallery ── --}}
                <div class="space-y-3">
                    <div class="aspect-square rounded-3xl relative overflow-hidden bg-white border border-slate-100 shadow-sm">
                        @if($product->images && count($product->images) > 0)
                            <img :src="mainImage"
                                 alt="{{ $product->name }}"
                                 class="w-full h-full object-cover transition-all duration-300"
                                 id="mainProductImage">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-50 to-slate-100">
                                <div class="w-24 h-24 rounded-3xl bg-slate-200/60 flex items-center justify-center">
                                    <span class="font-display font-bold text-5xl text-slate-300">{{ strtoupper(substr($product->name, 0, 2)) }}</span>
                                </div>
                            </div>
                        @endif

                        @if(!$product->isInStock())
                            <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm flex items-center justify-center">
                                <span class="px-6 py-3 rounded-2xl bg-red-500 text-white font-bold text-sm uppercase tracking-wider"
                                      x-text="$store.lang.current === 'en' ? 'Out of Stock' : 'Agotado'"></span>
                            </div>
                        @endif
                    </div>

                    @if($product->images && count($product->images) > 1)
                        <div class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                            @foreach($product->images as $img)
                                <button @click="mainImage = '{{ asset('storage/' . $img) }}'"
                                        class="aspect-square rounded-xl overflow-hidden bg-white border-2 transition-all duration-200 hover:border-blue-500 focus:border-blue-600 focus:outline-none shadow-sm"
                                        :class="mainImage === '{{ asset('storage/' . $img) }}' ? 'border-blue-500 ring-2 ring-blue-500/20' : 'border-slate-100'">
                                    <img src="{{ asset('storage/' . $img) }}" alt="{{ $product->name }}" class="w-full h-full object-cover" loading="lazy">
                                </button>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- ── RIGHT: Product Info ── --}}
                <div class="lg:py-2">
                    {{-- Category --}}
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 text-blue-700 text-xs font-semibold uppercase tracking-wider">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/></svg>
                        {{ $product->category->name }}
                    </span>

                    {{-- Name --}}
                    <h1 class="text-3xl lg:text-4xl font-display font-bold text-slate-900 mt-4 leading-tight">{{ $product->name }}</h1>

                    {{-- Description --}}
                    <p class="text-slate-500 leading-relaxed mt-4 text-[15px]">{{ $product->description }}</p>

                    {{-- Price --}}
                    <div class="mt-6 flex items-baseline gap-3">
                        <span class="text-4xl font-price font-extrabold text-slate-900 tracking-tight">${{ number_format($product->price, 2) }}</span>
                        @if($product->isInStock())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-50 text-emerald-700 text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span x-text="$store.lang.current === 'en' ? 'In Stock' : 'Disponible'"></span>
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-red-50 text-red-700 text-xs font-semibold">
                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                <span x-text="$store.lang.current === 'en' ? 'Out of Stock' : 'Agotado'"></span>
                            </span>
                        @endif
                    </div>

                    {{-- Divider --}}
                    <div class="border-t border-slate-100 my-6"></div>

                    {{-- Add to Cart Form --}}
                    @if($product->isInStock())
                        <form action="{{ route('store.cart.add') }}" method="POST" class="space-y-5">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">

                            {{-- Sizes --}}
                            @if($product->sizes)
                                <div>
                                    <label class="block text-slate-700 text-sm font-semibold mb-3"
                                           x-text="$store.lang.current === 'en' ? 'Size' : 'Talla'"></label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($product->sizes as $size)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="size" value="{{ $size }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                                <span class="block px-5 py-2.5 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-500 peer-checked:border-slate-900 peer-checked:bg-slate-900 peer-checked:text-white transition-all duration-200 hover:border-slate-300">{{ $size }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Colors --}}
                            @if($product->colors)
                                <div>
                                    <label class="block text-slate-700 text-sm font-semibold mb-3"
                                           x-text="$store.lang.current === 'en' ? 'Color' : 'Color'"></label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($product->colors as $color)
                                            <label class="cursor-pointer">
                                                <input type="radio" name="color" value="{{ $color }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}>
                                                <span class="block px-5 py-2.5 rounded-xl border-2 border-slate-200 text-sm font-semibold text-slate-500 peer-checked:border-slate-900 peer-checked:bg-slate-900 peer-checked:text-white transition-all duration-200 hover:border-slate-300">{{ $color }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Quantity --}}
                            <div>
                                <label class="block text-slate-700 text-sm font-semibold mb-3"
                                       x-text="$store.lang.current === 'en' ? 'Quantity' : 'Cantidad'"></label>
                                <div class="inline-flex items-center rounded-xl border-2 border-slate-200 overflow-hidden">
                                    <button type="button" @click="quantity = Math.max(1, quantity - 1)"
                                            class="w-12 h-12 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                    </button>
                                    <input type="number" name="quantity" x-model="quantity" min="1" :max="maxQty"
                                           class="w-16 h-12 text-center text-slate-900 font-bold text-lg border-x-2 border-slate-200 focus:outline-none bg-white [appearance:textfield] [&::-webkit-outer-spin-button]:appearance-none [&::-webkit-inner-spin-button]:appearance-none">
                                    <button type="button" @click="quantity = Math.min(maxQty, quantity + 1)"
                                            class="w-12 h-12 flex items-center justify-center text-slate-500 hover:bg-slate-50 hover:text-slate-900 transition-colors">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                    </button>
                                </div>
                            </div>

                            {{-- Add to Cart Button --}}
                            <button type="submit"
                                    class="w-full flex items-center justify-center gap-3 py-4 px-6 rounded-2xl bg-slate-900 text-white font-bold text-base hover:bg-blue-600 transition-all duration-200 shadow-xl shadow-slate-900/20 hover:shadow-blue-600/30 active:scale-[0.98]">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Add to Cart' : 'Agregar al Carrito'"></span>
                            </button>
                        </form>
                    @endif

                    {{-- Product Meta --}}
                    <div class="mt-8 p-5 rounded-2xl bg-white border border-slate-100 space-y-3">
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-400 w-20 shrink-0">SKU</span>
                            <span class="text-slate-700 font-mono text-xs bg-slate-50 px-2 py-0.5 rounded">{{ $product->sku ?? '—' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <span class="text-slate-400 w-20 shrink-0" x-text="$store.lang.current === 'en' ? 'Stock' : 'Stock'"></span>
                            <span class="font-semibold {{ $product->inventory > 5 ? 'text-emerald-600' : ($product->inventory > 0 ? 'text-amber-600' : 'text-red-600') }}">
                                {{ $product->inventory }} <span x-text="$store.lang.current === 'en' ? 'units' : 'unidades'" class="font-normal text-slate-400"></span>
                            </span>
                        </div>
                        @if($product->sizes)
                            <div class="flex items-center gap-3 text-sm">
                                <span class="text-slate-400 w-20 shrink-0" x-text="$store.lang.current === 'en' ? 'Sizes' : 'Tallas'"></span>
                                <span class="text-slate-700">{{ implode(', ', $product->sizes) }}</span>
                            </div>
                        @endif
                        @if($product->colors)
                            <div class="flex items-center gap-3 text-sm">
                                <span class="text-slate-400 w-20 shrink-0" x-text="$store.lang.current === 'en' ? 'Colors' : 'Colores'"></span>
                                <span class="text-slate-700">{{ implode(', ', $product->colors) }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════ --}}
            {{-- RELATED PRODUCTS --}}
            {{-- ══════════════════════════════════════════ --}}
            @if($related->count())
                <div class="mt-20 pt-10 border-t border-slate-100">
                    <h2 class="text-2xl font-display font-bold text-slate-900 mb-8"
                        x-text="$store.lang.current === 'en' ? 'Related Products' : 'Productos Relacionados'"></h2>
                    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                        @foreach($related as $item)
                            <a href="{{ route('store.show', $item) }}" class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-lg hover:border-slate-200 transition-all duration-300 hover:-translate-y-1">
                                <div class="aspect-square relative overflow-hidden bg-slate-100">
                                    @if($item->images && count($item->images) > 0)
                                        <img src="{{ asset('storage/' . $item->images[0]) }}" alt="{{ $item->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500" loading="lazy">
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                            <span class="font-display font-bold text-2xl text-slate-300">{{ strtoupper(substr($item->name, 0, 2)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="p-4">
                                    <h3 class="text-slate-900 font-semibold text-sm group-hover:text-blue-600 transition-colors line-clamp-1">{{ $item->name }}</h3>
                                    <p class="text-slate-900 font-price font-extrabold text-lg mt-1 tracking-tight">${{ number_format($item->price, 2) }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
