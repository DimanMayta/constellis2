@extends('layouts.app')
@section('title', 'NSG Store')

@section('content')
<div x-data="{ cartCount: {{ $cartCount }}, showSearch: false }" class="bg-slate-50 min-h-screen">

    {{-- ══════════════════════════════════════════ --}}
    {{-- HERO HEADER --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950">
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(59,130,246,0.15),transparent_60%)]"></div>
            <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(99,102,241,0.1),transparent_60%)]"></div>
            <div class="absolute inset-0 line-grid opacity-5"></div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-10 lg:py-14">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="w-10 h-10 rounded-xl bg-blue-500/20 border border-blue-400/30 flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z"/></svg>
                        </div>
                        <span class="text-blue-300/80 text-xs font-bold tracking-[0.2em] uppercase"
                              x-text="$store.lang.current === 'en' ? 'Employee Exclusive' : 'Exclusivo para Empleados'"></span>
                    </div>
                    <h1 class="text-3xl lg:text-4xl font-display font-bold text-white tracking-tight">NSG Store</h1>
                    <p class="text-slate-400 mt-2 text-sm max-w-md"
                       x-text="$store.lang.current === 'en' ? 'Official merchandise and gear for NSG team members' : 'Mercancía y equipo oficial para miembros del equipo NSG'"></p>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    {{-- Search toggle --}}
                    <button @click="showSearch = !showSearch"
                            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/5 border border-white/10 text-white/70 text-sm font-medium hover:bg-white/10 hover:text-white transition-all duration-200">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <span x-text="$store.lang.current === 'en' ? 'Search' : 'Buscar'"></span>
                    </button>

                    {{-- Cart --}}
                    <a href="{{ route('store.cart') }}"
                       class="relative inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600/20 border border-blue-400/30 text-blue-200 text-sm font-medium hover:bg-blue-600/30 hover:text-white transition-all duration-200 group">
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                        <span x-text="$store.lang.current === 'en' ? 'Cart' : 'Carrito'"></span>
                        <template x-if="cartCount > 0">
                            <span class="absolute -top-2 -right-2 w-5 h-5 rounded-full bg-blue-500 text-white text-[10px] font-bold flex items-center justify-center ring-2 ring-slate-900 animate-pulse" x-text="cartCount"></span>
                        </template>
                    </a>

                    {{-- User & Logout --}}
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white text-xs font-bold ring-2 ring-white/20">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>
                        <div class="hidden sm:block">
                            <p class="text-white text-xs font-medium leading-tight">{{ auth()->user()->name }}</p>
                            <form action="{{ route('store.logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="text-slate-500 text-[10px] hover:text-red-400 transition-colors"
                                        x-text="$store.lang.current === 'en' ? 'Sign Out' : 'Cerrar Sesión'"></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search bar (expandable) --}}
            <div x-show="showSearch" x-collapse x-cloak class="mt-6">
                <form action="{{ route('store.index') }}" method="GET" class="relative max-w-xl">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full pl-12 pr-4 py-3.5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:outline-none transition-all backdrop-blur-sm text-sm"
                           x-bind:placeholder="$store.lang.current === 'en' ? 'Search products by name, description, or SKU...' : 'Buscar productos por nombre, descripción o SKU...'"
                           autofocus>
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </form>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════ --}}
    {{-- NOTIFICATIONS --}}
    {{-- ══════════════════════════════════════════ --}}
    @if(session('success'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition>
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/60 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-emerald-800 text-sm font-medium flex-1">{{ session('success') }}</p>
                <button @click="show = false" class="text-emerald-400 hover:text-emerald-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-red-50 border border-red-200/60 shadow-sm">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                </div>
                <p class="text-red-800 text-sm font-medium flex-1">{{ session('error') }}</p>
                <button @click="show = false" class="text-red-400 hover:text-red-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    @endif

    {{-- ══════════════════════════════════════════ --}}
    {{-- CATALOG --}}
    {{-- ══════════════════════════════════════════ --}}
    <section class="py-10 lg:py-14">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Category Filter Pills --}}
            <div class="flex items-center gap-3 mb-10 overflow-x-auto pb-2 scrollbar-hide">
                <span class="text-slate-400 text-xs font-semibold uppercase tracking-wider shrink-0 mr-1"
                      x-text="$store.lang.current === 'en' ? 'Filter:' : 'Filtrar:'"></span>
                <a href="{{ route('store.index', request()->only('search')) }}"
                   class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ !request('category') ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'bg-white text-slate-500 border border-slate-200 hover:border-slate-300 hover:text-slate-700 hover:shadow-sm' }}">
                    <span x-text="$store.lang.current === 'en' ? 'All Products' : 'Todos'"></span>
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('store.index', array_merge(request()->only('search'), ['category' => $cat->slug])) }}"
                       class="shrink-0 px-5 py-2 rounded-full text-sm font-semibold transition-all duration-200 {{ request('category') === $cat->slug ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'bg-white text-slate-500 border border-slate-200 hover:border-slate-300 hover:text-slate-700 hover:shadow-sm' }}">
                        {{ $cat->name }}
                    </a>
                @endforeach
            </div>

            {{-- Results count --}}
            @if(request('search'))
                <div class="flex items-center gap-2 mb-6">
                    <p class="text-slate-500 text-sm">
                        <span x-text="$store.lang.current === 'en' ? '{{ $products->total() }} results for' : '{{ $products->total() }} resultados para'"></span>
                        <strong class="text-slate-700">"{{ request('search') }}"</strong>
                    </p>
                    <a href="{{ route('store.index', request()->only('category')) }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">
                        <span x-text="$store.lang.current === 'en' ? 'Clear' : 'Limpiar'"></span>
                    </a>
                </div>
            @endif

            {{-- Products Grid --}}
            @if($products->count() > 0)
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
                    @foreach($products as $product)
                        <div class="group bg-white rounded-2xl border border-slate-100 overflow-hidden hover:shadow-xl hover:shadow-slate-200/50 hover:border-slate-200 transition-all duration-300 hover:-translate-y-1 flex flex-col">
                            {{-- Image --}}
                            <a href="{{ route('store.show', $product) }}" class="block relative aspect-square overflow-hidden bg-slate-100">
                                @if($product->images && count($product->images) > 0)
                                    <img src="{{ asset('storage/' . $product->images[0]) }}"
                                         alt="{{ $product->name }}"
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 ease-out"
                                         loading="lazy">
                                @else
                                    <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                        <div class="w-16 h-16 rounded-2xl bg-slate-300/50 flex items-center justify-center">
                                            <span class="font-display font-bold text-2xl text-slate-400">{{ strtoupper(substr($product->name, 0, 2)) }}</span>
                                        </div>
                                    </div>
                                @endif

                                {{-- Out of stock overlay --}}
                                @if(!$product->isInStock())
                                    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm flex items-center justify-center">
                                        <span class="px-4 py-2 rounded-full bg-red-500/90 text-white text-xs font-bold uppercase tracking-wider"
                                              x-text="$store.lang.current === 'en' ? 'Out of Stock' : 'Agotado'"></span>
                                    </div>
                                @endif

                                {{-- Category badge --}}
                                <div class="absolute top-3 left-3">
                                    <span class="px-2.5 py-1 rounded-lg bg-white/90 backdrop-blur-sm text-slate-600 text-[10px] font-bold uppercase tracking-wider shadow-sm">{{ $product->category->name }}</span>
                                </div>
                            </a>

                            {{-- Content --}}
                            <div class="p-5 flex flex-col flex-1">
                                <a href="{{ route('store.show', $product) }}" class="block mb-1">
                                    <h3 class="text-slate-900 font-display font-semibold text-[15px] leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">{{ $product->name }}</h3>
                                </a>
                                <p class="text-slate-400 text-xs leading-relaxed line-clamp-2 mb-4 flex-1">{{ $product->description }}</p>

                                <div class="flex items-end justify-between mt-auto pt-3 border-t border-slate-50">
                                    <div>
                                        <span class="text-2xl font-price font-extrabold text-slate-900 tracking-tight">${{ number_format($product->price, 2) }}</span>
                                        @if($product->isInStock())
                                            <p class="text-emerald-500 text-[10px] font-semibold mt-0.5 flex items-center gap-1">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 inline-block"></span>
                                                <span x-text="$store.lang.current === 'en' ? 'In Stock' : 'Disponible'"></span>
                                            </p>
                                        @endif
                                    </div>

                                    @if($product->isInStock())
                                        @if(!$product->sizes && !$product->colors)
                                            <form action="{{ route('store.cart.add') }}" method="POST" class="inline">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <input type="hidden" name="quantity" value="1">
                                                <button type="submit"
                                                        class="w-11 h-11 rounded-xl bg-slate-900 text-white flex items-center justify-center hover:bg-blue-600 transition-all duration-200 shadow-lg shadow-slate-900/20 hover:shadow-blue-600/30 hover:scale-105 active:scale-95"
                                                        x-bind:title="$store.lang.current === 'en' ? 'Add to Cart' : 'Agregar al Carrito'">
                                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                                </button>
                                            </form>
                                        @else
                                            <a href="{{ route('store.show', $product) }}"
                                               class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-semibold hover:bg-blue-600 transition-all duration-200 shadow-lg shadow-slate-900/20 hover:shadow-blue-600/30">
                                                <span x-text="$store.lang.current === 'en' ? 'Select Options' : 'Ver Opciones'"></span>
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-10">{{ $products->links() }}</div>
            @else
                <div class="text-center py-20">
                    <div class="w-20 h-20 rounded-3xl bg-slate-100 flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                    </div>
                    <h3 class="text-slate-700 font-display font-semibold text-lg mb-2"
                        x-text="$store.lang.current === 'en' ? 'No Products Found' : 'No se encontraron productos'"></h3>
                    <p class="text-slate-400 text-sm mb-6"
                       x-text="$store.lang.current === 'en' ? 'Try adjusting your filters or search terms.' : 'Intenta ajustar los filtros o los términos de búsqueda.'"></p>
                    <a href="{{ route('store.index') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-slate-900 text-white text-sm font-semibold hover:bg-blue-600 transition-all">
                        <span x-text="$store.lang.current === 'en' ? 'View All Products' : 'Ver Todos los Productos'"></span>
                    </a>
                </div>
            @endif
        </div>
    </section>
</div>
@endsection
