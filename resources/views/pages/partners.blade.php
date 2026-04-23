@extends('layouts.app')
@section('title', 'Strategic Partners — Constellis')

@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Strategic Alliances</span>
        <h1 class="section-heading-white mb-6">Our Partners</h1>
        <p class="section-subheading-white mx-auto">We collaborate with industry-leading organizations to deliver comprehensive solutions</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($partners as $i => $partner)
                <a href="{{ $partner->website_url ?? '#' }}" target="_blank" rel="noopener" class="card p-8 group cursor-pointer" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300 shrink-0">
                            <span class="font-display font-bold text-xl">{{ substr($partner->name, 0, 2) }}</span>
                        </div>
                        <div>
                            <h3 class="text-slate-900 font-display font-semibold text-lg group-hover:text-blue-600 transition-colors">{{ $partner->name }}</h3>
                            <span class="text-xs font-medium px-2 py-0.5 rounded-full bg-slate-100 text-slate-500 capitalize">{{ $partner->partnership_type }}</span>
                        </div>
                    </div>
                    <p class="text-slate-500 text-sm leading-relaxed mb-6">{{ $partner->description }}</p>
                    <span class="inline-flex items-center gap-2 text-blue-600 text-sm font-semibold group-hover:gap-3 transition-all">
                        Visit Website
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    </span>
                </a>
            @empty
                <div class="col-span-3 text-center py-20">
                    <p class="text-slate-400 text-lg">Partners directory will be populated soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
