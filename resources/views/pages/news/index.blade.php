@extends('layouts.app')
@section('title', 'News — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Latest Updates</span>
        <h1 class="section-heading-white mb-6">News & Insights</h1>
        <p class="section-subheading-white">Stay updated with the latest developments and announcements from Constellis.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($articles ?? [] as $i => $article)
                <a href="{{ url('/news/' . $article->slug) }}" class="news-card group" data-animate style="animation-delay: {{ ($i % 6) * 100 }}ms">
                    <div class="overflow-hidden img-hover-shine">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="news-image">
                        @else
                            <div class="img-placeholder h-56 relative"><div class="absolute inset-0 flex items-center justify-center z-10"><svg class="w-10 h-10 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg></div></div>
                        @endif
                    </div>
                    <div class="p-7">
                        <time class="text-blue-600 text-xs font-bold tracking-wider uppercase">{{ $article->published_at?->format('M d, Y') ?? 'Recent' }}</time>
                        <h3 class="text-slate-900 font-display font-semibold text-lg mt-3 mb-3 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">{{ $article->title }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed line-clamp-3">{{ $article->excerpt ?? Str::limit(strip_tags($article->content), 150) }}</p>
                        <span class="inline-flex items-center gap-2 text-blue-600 text-sm font-semibold mt-5 group-hover:gap-3 transition-all">Read More <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg></span>
                    </div>
                </a>
            @empty
                <p class="text-slate-400 col-span-3 text-center py-12">No news articles published yet.</p>
            @endforelse
        </div>
        @if(method_exists($articles ?? collect(), 'links'))<div class="mt-12">{{ $articles->links() }}</div>@endif
    </div>
</section>
@endsection
