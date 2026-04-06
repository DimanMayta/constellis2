@extends('layouts.app')
@section('title', ($service->name ?? 'Service') . ' — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-blue-200 text-sm mb-8">
            <a href="{{ url('/what-we-do') }}" class="hover:text-white transition-colors">Services</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ url('/what-we-do/' . $service->category->slug) }}" class="hover:text-white transition-colors">{{ $service->category->name }}</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80">{{ $service->name }}</span>
        </nav>
        <h1 class="section-heading-white">{{ $service->name }}</h1>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none text-slate-600 prose-headings:font-display prose-headings:text-slate-900 prose-a:text-blue-600 prose-strong:text-slate-900">{!! $service->content !!}</div>
        <div class="mt-12"><a href="{{ url('/contact') }}" class="btn-primary">Discuss Your Requirements <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></a></div>
    </div>
</section>
@endsection
