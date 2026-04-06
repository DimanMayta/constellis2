@extends('layouts.app')
@section('title', $product->name . ' — Constellis Store')

@section('content')
<section class="py-8 bg-white -mt-20 pt-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('store.index') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Store
        </a>

        <div class="grid lg:grid-cols-2 gap-12">
            <div class="aspect-square img-placeholder rounded-3xl relative overflow-hidden">
                <div class="absolute inset-0 flex items-center justify-center z-10">
                    <span class="font-display font-bold text-6xl text-white/20">{{ substr($product->name, 0, 2) }}</span>
                </div>
            </div>
            <div>
                <span class="text-blue-600 text-sm font-semibold">{{ $product->category->name }}</span>
                <h1 class="text-3xl font-display font-bold text-slate-900 mt-2 mb-4">{{ $product->name }}</h1>
                <p class="text-slate-500 leading-relaxed mb-6">{{ $product->description }}</p>
                <p class="text-4xl font-display font-bold text-slate-900 mb-8">${{ number_format($product->price, 2) }}</p>

                <form action="{{ route('store.cart.add') }}" method="POST" class="space-y-4">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    @if($product->sizes)
                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-2">Size</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->sizes as $size)
                                    <label class="cursor-pointer"><input type="radio" name="size" value="{{ $size }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}><span class="block px-4 py-2 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all">{{ $size }}</span></label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($product->colors)
                        <div>
                            <label class="block text-slate-700 text-sm font-semibold mb-2">Color</label>
                            <div class="flex flex-wrap gap-2">
                                @foreach($product->colors as $color)
                                    <label class="cursor-pointer"><input type="radio" name="color" value="{{ $color }}" class="sr-only peer" {{ $loop->first ? 'checked' : '' }}><span class="block px-4 py-2 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 transition-all">{{ $color }}</span></label>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    <div>
                        <label class="block text-slate-700 text-sm font-semibold mb-2">Quantity</label>
                        <select name="quantity" class="px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:border-blue-500 focus:outline-none">
                            @for($i = 1; $i <= min(10, $product->inventory); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <button type="submit" class="btn-primary w-full py-4 text-base">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17"/></svg>
                        Add to Cart
                    </button>
                </form>

                <div class="mt-6 p-4 rounded-xl bg-slate-50 border border-slate-100">
                    <p class="text-slate-500 text-xs"><strong class="text-slate-700">SKU:</strong> {{ $product->sku }}</p>
                    <p class="text-slate-500 text-xs mt-1"><strong class="text-slate-700">In Stock:</strong> {{ $product->inventory }} units</p>
                </div>
            </div>
        </div>

        @if($related->count())
            <div class="mt-20">
                <h2 class="text-2xl font-display font-bold text-slate-900 mb-8">Related Products</h2>
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($related as $item)
                        <a href="{{ route('store.show', $item) }}" class="card overflow-hidden group">
                            <div class="aspect-square img-placeholder relative"><div class="absolute inset-0 flex items-center justify-center z-10"><span class="font-display font-bold text-2xl text-white/30">{{ substr($item->name, 0, 2) }}</span></div></div>
                            <div class="p-4">
                                <h3 class="text-slate-900 font-semibold text-sm group-hover:text-blue-600 transition-colors">{{ $item->name }}</h3>
                                <p class="text-blue-600 font-bold mt-1">${{ number_format($item->price, 2) }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
