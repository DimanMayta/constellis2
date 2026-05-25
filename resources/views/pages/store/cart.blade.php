@extends('layouts.app')
@section('title', 'Cart — NSG Store')

@section('content')
<div x-data="{ cartCount: {{ $cartCount }} }" class="bg-slate-50 min-h-screen">

    {{-- Mini Header --}}
    <div class="bg-white border-b border-slate-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <a href="{{ route('store.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm font-medium transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span x-text="$store.lang.current === 'en' ? 'Continue Shopping' : 'Seguir Comprando'"></span>
            </a>
            <div class="flex items-center gap-2 text-slate-400 text-sm">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                <span x-text="$store.lang.current === 'en' ? '{{ count($products) }} item(s)' : '{{ count($products) }} artículo(s)'"></span>
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    @if(session('success'))
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition>
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-emerald-50 border border-emerald-200/60">
                <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                <p class="text-emerald-800 text-sm font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif
    @if(session('error'))
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-red-50 border border-red-200/60">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
                </div>
                <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
            </div>
        </div>
    @endif

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Title --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-display font-bold text-slate-900"
                    x-text="$store.lang.current === 'en' ? 'Shopping Cart' : 'Carrito de Compras'"></h1>
                <p class="text-slate-400 text-sm mt-0.5"
                   x-text="$store.lang.current === 'en' ? '{{ count($products) }} item(s) in your cart' : '{{ count($products) }} artículo(s) en tu carrito'"></p>
            </div>
        </div>

        @if(count($products) === 0)
            {{-- Empty Cart --}}
            <div class="bg-white rounded-3xl border border-slate-100 p-16 text-center">
                <div class="w-24 h-24 rounded-3xl bg-slate-50 flex items-center justify-center mx-auto mb-6">
                    <svg class="w-12 h-12 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"/></svg>
                </div>
                <h2 class="text-slate-700 font-display font-bold text-xl mb-2"
                    x-text="$store.lang.current === 'en' ? 'Your cart is empty' : 'Tu carrito está vacío'"></h2>
                <p class="text-slate-400 text-sm mb-8 max-w-sm mx-auto"
                   x-text="$store.lang.current === 'en' ? 'Browse our catalog and add products you love.' : 'Explora nuestro catálogo y agrega los productos que te gusten.'"></p>
                <a href="{{ route('store.index') }}"
                   class="inline-flex items-center gap-2 px-8 py-3.5 rounded-2xl bg-slate-900 text-white font-semibold hover:bg-blue-600 transition-all shadow-xl shadow-slate-900/20 hover:shadow-blue-600/30">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z"/></svg>
                    <span x-text="$store.lang.current === 'en' ? 'Browse Store' : 'Explorar Tienda'"></span>
                </a>
            </div>
        @else
            <div class="grid lg:grid-cols-3 gap-8">
                {{-- Cart Items --}}
                <div class="lg:col-span-2 space-y-4">
                    @foreach($products as $item)
                        <div class="bg-white rounded-2xl border border-slate-100 p-5 hover:shadow-md transition-shadow duration-200">
                            <div class="flex gap-5">
                                {{-- Thumbnail --}}
                                <a href="{{ route('store.show', $item['product']) }}" class="shrink-0">
                                    <div class="w-24 h-24 lg:w-28 lg:h-28 rounded-xl overflow-hidden bg-slate-100 relative">
                                        @if($item['product']->images && count($item['product']->images) > 0)
                                            <img src="{{ asset('storage/' . $item['product']->images[0]) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover hover:scale-110 transition-transform duration-300">
                                        @else
                                            <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                                <span class="text-slate-400 font-bold text-sm">{{ strtoupper(substr($item['product']->name, 0, 2)) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </a>

                                {{-- Details --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-3">
                                        <div class="min-w-0">
                                            <a href="{{ route('store.show', $item['product']) }}" class="block">
                                                <h3 class="text-slate-900 font-semibold text-[15px] hover:text-blue-600 transition-colors truncate">{{ $item['product']->name }}</h3>
                                            </a>
                                            <p class="text-slate-400 text-xs mt-0.5">{{ $item['product']->category->name ?? '' }}</p>

                                            {{-- Variants --}}
                                            @if($item['size'] || $item['color'])
                                                <div class="flex items-center gap-2 mt-2">
                                                    @if($item['size'])
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[11px] font-medium">
                                                            <span x-text="$store.lang.current === 'en' ? 'Size:' : 'Talla:'"></span> {{ $item['size'] }}
                                                        </span>
                                                    @endif
                                                    @if($item['color'])
                                                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-slate-100 text-slate-600 text-[11px] font-medium">
                                                            <span x-text="$store.lang.current === 'en' ? 'Color:' : 'Color:'"></span> {{ $item['color'] }}
                                                        </span>
                                                    @endif
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Remove --}}
                                        <form action="{{ route('store.cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="cart_key" value="{{ $item['key'] }}">
                                            <button type="submit"
                                                    class="w-8 h-8 rounded-lg text-slate-300 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-all"
                                                    x-bind:title="$store.lang.current === 'en' ? 'Remove' : 'Eliminar'">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>

                                    {{-- Quantity & Price Row --}}
                                    <div class="flex items-end justify-between mt-4">
                                        {{-- Quantity selector --}}
                                        <form action="{{ route('store.cart.update') }}" method="POST" class="inline-flex items-center rounded-lg border border-slate-200 overflow-hidden">
                                            @csrf
                                            <input type="hidden" name="cart_key" value="{{ $item['key'] }}">
                                            <button type="submit" name="quantity" value="{{ max(1, $item['quantity'] - 1) }}"
                                                    class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-50 transition-colors {{ $item['quantity'] <= 1 ? 'opacity-30 pointer-events-none' : '' }}">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                                            </button>
                                            <span class="w-10 h-9 flex items-center justify-center text-slate-900 font-bold text-sm border-x border-slate-200 bg-slate-50/50">{{ $item['quantity'] }}</span>
                                            <button type="submit" name="quantity" value="{{ min(10, $item['quantity'] + 1) }}"
                                                    class="w-9 h-9 flex items-center justify-center text-slate-400 hover:text-slate-900 hover:bg-slate-50 transition-colors {{ $item['quantity'] >= 10 ? 'opacity-30 pointer-events-none' : '' }}">
                                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                                            </button>
                                        </form>

                                        {{-- Line total --}}
                                        <div class="text-right">
                                            <p class="text-slate-900 font-price font-extrabold text-lg tracking-tight">${{ number_format($item['subtotal'], 2) }}</p>
                                            @if($item['quantity'] > 1)
                                                <p class="text-slate-400 text-[11px]">${{ number_format($item['product']->price, 2) }} × {{ $item['quantity'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Order Summary --}}
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl border border-slate-100 p-6 lg:sticky lg:top-20">
                        <h2 class="text-slate-900 font-display font-bold text-lg mb-5"
                            x-text="$store.lang.current === 'en' ? 'Order Summary' : 'Resumen del Pedido'"></h2>

                        <div class="space-y-3 mb-5">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 text-sm"
                                      x-text="$store.lang.current === 'en' ? 'Subtotal ({{ count($products) }} items)' : 'Subtotal ({{ count($products) }} artículos)'"></span>
                                <span class="text-slate-900 font-semibold">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-slate-500 text-sm"
                                      x-text="$store.lang.current === 'en' ? 'Shipping' : 'Envío'"></span>
                                <span class="text-emerald-600 text-sm font-medium"
                                      x-text="$store.lang.current === 'en' ? 'Internal' : 'Interno'"></span>
                            </div>
                        </div>

                        <div class="border-t border-slate-100 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-slate-900 font-price font-bold text-lg">Total</span>
                                <span class="text-slate-900 font-price font-extrabold text-2xl tracking-tight">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <a href="{{ route('store.checkout') }}"
                           class="w-full flex items-center justify-center gap-2 py-4 rounded-2xl bg-slate-900 text-white font-bold text-sm hover:bg-blue-600 transition-all duration-200 shadow-xl shadow-slate-900/20 hover:shadow-blue-600/30 active:scale-[0.98]">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span x-text="$store.lang.current === 'en' ? 'Proceed to Checkout' : 'Proceder al Pago'"></span>
                        </a>

                        <a href="{{ route('store.index') }}"
                           class="w-full flex items-center justify-center gap-2 py-3 mt-3 rounded-xl text-slate-500 text-sm font-medium hover:text-slate-900 hover:bg-slate-50 transition-all">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                            <span x-text="$store.lang.current === 'en' ? 'Continue Shopping' : 'Seguir Comprando'"></span>
                        </a>

                        {{-- Security badges --}}
                        <div class="mt-6 pt-5 border-t border-slate-100">
                            <div class="flex items-center gap-2 text-slate-400 text-[11px] mb-2">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.99 11.99 0 003 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285z"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Secure internal processing' : 'Procesamiento interno seguro'"></span>
                            </div>
                            <div class="flex items-center gap-2 text-slate-400 text-[11px]">
                                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 18.75a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 01-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 01-3 0m3 0a1.5 1.5 0 00-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 00-3.213-9.193 2.056 2.056 0 00-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 00-10.026 0 1.106 1.106 0 00-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Internal delivery to your department' : 'Entrega interna a tu departamento'"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
