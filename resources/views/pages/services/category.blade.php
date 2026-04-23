@extends('layouts.app')
@section('title', ($category->name ?? 'Services') . ' — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-blue-200 text-sm mb-8">
            <a href="{{ url('/what-we-do') }}" class="hover:text-white transition-colors">Services</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80">{{ $category->name }}</span>
        </nav>
        <h1 class="section-heading-white mb-6">{{ $category->name }}</h1>
        <p class="section-subheading-white">{{ $category->description }}</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($category->services as $i => $service)
                <a href="{{ url('/what-we-do/' . $category->slug . '/' . $service->slug) }}" class="card p-8 group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-5 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h3 class="text-slate-900 font-display font-semibold text-lg mb-3 group-hover:text-blue-600 transition-colors">{{ $service->name }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $service->short_description ?? 'Specialized service delivering mission-critical solutions.' }}</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
@endsection
