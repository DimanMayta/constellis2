@extends('layouts.app')
@section('title', $article->meta_title ?? $article->title . ' — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <nav class="flex items-center gap-2 text-blue-200 text-sm mb-8">
            <a href="{{ url('/news') }}" class="hover:text-white transition-colors">News</a>
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-white/80 line-clamp-1">{{ Str::limit($article->title, 50) }}</span>
        </nav>
        <time class="text-blue-200 text-sm font-medium tracking-wider uppercase block mb-4">{{ $article->published_at?->format('F d, Y') ?? 'Recent' }}</time>
        <h1 class="section-heading-white text-balance">{{ $article->title }}</h1>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        @if($article->featured_image)
            <div class="rounded-2xl overflow-hidden mb-12 shadow-blue-lg img-hover-zoom"><img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="w-full"></div>
        @endif
        <div class="prose prose-lg max-w-none text-slate-600 prose-headings:font-display prose-headings:text-slate-900 prose-a:text-blue-600 prose-strong:text-slate-900">{!! $article->content !!}</div>
        @if(isset($related) && $related->count() > 0)
            <div class="divider-gradient my-16"></div>
            <div data-animate>
                <h2 class="text-2xl font-display font-bold text-slate-900 mb-8">Related News</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($related as $rel)
                        <a href="{{ url('/news/' . $rel->slug) }}" class="card overflow-hidden group">
                            <div class="img-placeholder h-40 relative"><div class="absolute inset-0 flex items-center justify-center z-10"><svg class="w-8 h-8 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg></div></div>
                            <div class="p-5">
                                <time class="text-blue-600 text-xs font-bold">{{ $rel->published_at?->format('M d, Y') }}</time>
                                <h3 class="text-slate-900 font-display font-semibold text-sm mt-2 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $rel->title }}</h3>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
