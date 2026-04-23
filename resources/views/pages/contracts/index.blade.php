@extends('layouts.app')
@section('title', 'Contracts — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Government Contracts</span>
        <h1 class="section-heading-white mb-6">Contract Vehicles</h1>
        <p class="section-subheading-white">Constellis holds multiple government contract vehicles to efficiently deliver services to federal agencies.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($contracts ?? [] as $i => $contract)
                <div class="card p-8 group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-5 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <h3 class="text-slate-900 font-display font-bold text-lg mb-2 group-hover:text-blue-600 transition-colors">{{ $contract->name }}</h3>
                    @if($contract->contract_number)<p class="text-blue-600 text-xs font-semibold tracking-wider uppercase mb-3">{{ $contract->contract_number }}</p>@endif
                    <p class="text-slate-400 text-sm leading-relaxed mb-4">{{ $contract->description ?? 'Government contract vehicle for security and professional services.' }}</p>
                    @if($contract->entity)<span class="inline-flex px-3 py-1 rounded-full bg-slate-50 border border-slate-100 text-slate-500 text-xs font-medium">{{ $contract->entity }}</span>@endif
                </div>
            @empty
                <p class="text-slate-400 col-span-3 text-center py-12">Contracts will appear here once configured.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
