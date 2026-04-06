@extends('layouts.app')
@section('title', $page->meta_title ?? $page->title . ' — Constellis')
@section('meta_description', $page->meta_description ?? '')
@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        @if($page->hero_title)<h1 class="section-heading-white mb-6">{!! $page->hero_title !!}</h1>@else<h1 class="section-heading-white mb-6">{{ $page->title }}</h1>@endif
        @if($page->hero_subtitle)<p class="section-subheading-white">{{ $page->hero_subtitle }}</p>@endif
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="prose prose-lg max-w-none text-slate-600 prose-headings:font-display prose-headings:text-slate-900 prose-a:text-blue-600 prose-strong:text-slate-900">{!! $page->content !!}</div>
    </div>
</section>
@endsection
