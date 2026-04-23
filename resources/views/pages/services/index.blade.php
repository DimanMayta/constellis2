@extends('layouts.app')
@section('title', 'What We Do — Constellis Services')
@section('content')

<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-0 right-0 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">What We Do</span>
        <h1 class="section-heading-white mb-6">Our Services</h1>
        <p class="section-subheading-white">Comprehensive security, intelligence, training, and operational support solutions deployed across the globe.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 gap-8">
            @forelse($categories ?? [] as $i => $category)
                <a href="{{ url('/what-we-do/' . $category->slug) }}" class="card p-8 group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="flex items-start gap-6">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 group-hover:shadow-blue-md transition-all duration-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div class="flex-1">
                            <h3 class="text-slate-900 font-display font-semibold text-xl mb-3 group-hover:text-blue-600 transition-colors">{{ $category->name }}</h3>
                            <p class="text-slate-400 text-sm leading-relaxed mb-4">{{ $category->description ?? 'Specialized solutions tailored to mission-critical requirements.' }}</p>
                            @if($category->services->count() > 0)
                                <div class="flex flex-wrap gap-2">
                                    @foreach($category->services->take(3) as $service)
                                        <span class="px-3 py-1 rounded-full bg-slate-50 border border-slate-100 text-slate-500 text-xs font-medium">{{ $service->name }}</span>
                                    @endforeach
                                    @if($category->services->count() > 3)
                                        <span class="px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-600 text-xs font-semibold">+{{ $category->services->count() - 3 }} more</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </a>
            @empty
                <p class="text-slate-400 col-span-2 text-center py-12">Service categories will appear here once populated.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
