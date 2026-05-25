@extends('layouts.app')
@section('title', 'Checkout — NSG Store')

@section('content')
<div x-data="{ cartCount: {{ $cartCount }} }" class="bg-slate-50 min-h-screen">

    {{-- Mini Header --}}
    <div class="bg-white border-b border-slate-100 sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <a href="{{ route('store.cart') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-slate-900 text-sm font-medium transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span x-text="$store.lang.current === 'en' ? 'Back to Cart' : 'Volver al Carrito'"></span>
            </a>

            {{-- Progress steps --}}
            <div class="hidden sm:flex items-center gap-2 text-xs">
                <span class="text-slate-400">
                    <span x-text="$store.lang.current === 'en' ? 'Store' : 'Tienda'"></span>
                </span>
                <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-400">
                    <span x-text="$store.lang.current === 'en' ? 'Cart' : 'Carrito'"></span>
                </span>
                <svg class="w-3 h-3 text-slate-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <span class="text-slate-900 font-semibold" x-text="$store.lang.current === 'en' ? 'Checkout' : 'Pago'"></span>
            </div>
        </div>
    </div>

    {{-- Notifications --}}
    @if(session('error'))
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-6" x-data="{ show: true }" x-show="show" x-transition>
            <div class="flex items-center gap-3 p-4 rounded-2xl bg-red-50 border border-red-200/60">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01"/></svg>
                </div>
                <p class="text-red-800 text-sm font-medium flex-1">{{ session('error') }}</p>
                <button @click="show = false" class="text-red-400 hover:text-red-600"><svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
            </div>
        </div>
    @endif

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Title --}}
        <div class="flex items-center gap-4 mb-8">
            <div class="w-12 h-12 rounded-2xl bg-slate-900 flex items-center justify-center">
                <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div>
                <h1 class="text-2xl lg:text-3xl font-display font-bold text-slate-900"
                    x-text="$store.lang.current === 'en' ? 'Checkout' : 'Pago'"></h1>
                <p class="text-slate-400 text-sm mt-0.5"
                   x-text="$store.lang.current === 'en' ? 'Review your order and complete purchase' : 'Revisa tu pedido y completa la compra'"></p>
            </div>
        </div>

        <div class="grid lg:grid-cols-5 gap-8">
            {{-- ── LEFT: Order Form ── --}}
            <div class="lg:col-span-3">
                <form action="{{ route('store.checkout.process') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Shipping Address --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-xl bg-blue-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                            </div>
                            <h2 class="font-display font-semibold text-slate-900"
                                x-text="$store.lang.current === 'en' ? 'Delivery Address' : 'Dirección de Entrega'"></h2>
                        </div>
                        <div>
                            <textarea id="shipping_address" name="shipping_address" rows="3" required
                                      class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none text-sm"
                                      x-bind:placeholder="$store.lang.current === 'en' ? 'Office, department, building, or full address...' : 'Oficina, departamento, edificio, o dirección completa...'"
                            >{{ old('shipping_address') }}</textarea>
                            @error('shipping_address') <p class="text-red-500 text-xs mt-1.5">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div class="bg-white rounded-2xl border border-slate-100 p-6">
                        <div class="flex items-center gap-3 mb-5">
                            <div class="w-8 h-8 rounded-xl bg-amber-50 flex items-center justify-center">
                                <svg class="w-4 h-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 01.865-.501 48.172 48.172 0 003.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z"/></svg>
                            </div>
                            <div>
                                <h2 class="font-display font-semibold text-slate-900"
                                    x-text="$store.lang.current === 'en' ? 'Order Notes' : 'Notas del Pedido'"></h2>
                                <p class="text-slate-400 text-xs"
                                   x-text="$store.lang.current === 'en' ? 'Optional' : 'Opcional'"></p>
                            </div>
                        </div>
                        <textarea id="notes" name="notes" rows="2"
                                  class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none text-sm"
                                  x-bind:placeholder="$store.lang.current === 'en' ? 'Any special instructions for your order...' : 'Instrucciones especiales para tu pedido...'"
                        >{{ old('notes') }}</textarea>
                    </div>

                    {{-- Info notice --}}
                    <div class="flex items-start gap-3 p-4 rounded-2xl bg-blue-50/50 border border-blue-100">
                        <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z"/></svg>
                        <p class="text-blue-700 text-sm leading-relaxed"
                           x-text="$store.lang.current === 'en' ? 'Orders are processed internally and fulfilled through NSG logistics. You will be notified when your order ships.' : 'Los pedidos se procesan internamente a través de la logística de NSG. Se le notificará cuando su pedido sea enviado.'"></p>
                    </div>

                    {{-- Submit --}}
                    <button type="submit"
                            class="w-full flex items-center justify-center gap-3 py-4 px-6 rounded-2xl bg-slate-900 text-white font-bold text-base hover:bg-blue-600 transition-all duration-200 shadow-xl shadow-slate-900/20 hover:shadow-blue-600/30 active:scale-[0.98]">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span x-text="$store.lang.current === 'en' ? 'Place Order' : 'Realizar Pedido'"></span>
                    </button>
                </form>
            </div>

            {{-- ── RIGHT: Order Summary ── --}}
            <div class="lg:col-span-2">
                <div class="bg-white rounded-2xl border border-slate-100 p-6 lg:sticky lg:top-20">
                    <h2 class="text-slate-900 font-display font-bold text-lg mb-5"
                        x-text="$store.lang.current === 'en' ? 'Order Summary' : 'Resumen del Pedido'"></h2>

                    <div class="space-y-4 mb-5 max-h-80 overflow-y-auto pr-1">
                        @foreach($items as $item)
                            <div class="flex gap-3 pb-4 border-b border-slate-50 last:border-0 last:pb-0">
                                <div class="w-14 h-14 rounded-xl overflow-hidden bg-slate-100 shrink-0 relative">
                                    @if($item['product']->images && count($item['product']->images) > 0)
                                        <img src="{{ asset('storage/' . $item['product']->images[0]) }}" alt="{{ $item['product']->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="absolute inset-0 flex items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200">
                                            <span class="text-slate-400 font-bold text-[10px]">{{ strtoupper(substr($item['product']->name, 0, 2)) }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="text-slate-900 font-medium text-sm truncate">{{ $item['product']->name }}</p>
                                    <div class="flex items-center gap-1.5 mt-0.5 flex-wrap">
                                        <span class="text-slate-400 text-xs">× {{ $item['quantity'] }}</span>
                                        @if($item['size'])
                                            <span class="text-slate-400 text-xs">· {{ $item['size'] }}</span>
                                        @endif
                                        @if($item['color'])
                                            <span class="text-slate-400 text-xs">· {{ $item['color'] }}</span>
                                        @endif
                                    </div>
                                </div>
                                <span class="text-slate-900 font-semibold text-sm shrink-0">${{ number_format($item['product']->price * $item['quantity'], 2) }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="border-t border-slate-100 pt-4">
                        <div class="flex justify-between items-center">
                            <span class="text-slate-900 font-price font-bold text-lg">Total</span>
                            <span class="text-slate-900 font-price font-extrabold text-2xl tracking-tight">${{ number_format($total, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
