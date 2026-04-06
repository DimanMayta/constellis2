@extends('layouts.app')

@section('title', 'Executive Leadership — Constellis')
@section('meta_description', 'Meet the executive leadership team guiding Constellis\' mission to provide world-class security solutions.')

@section('content')
{{-- Hero --}}
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-0 right-0 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Who We Are</span>
        <h1 class="section-heading-white mb-6">Executive Leadership</h1>
        <p class="section-subheading-white">Our leadership team brings decades of experience in security, intelligence, and military operations.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg>
    </div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            @forelse($leaders ?? [] as $i => $leader)
                <a href="{{ route('about.leader', $leader) }}" class="card overflow-hidden group cursor-pointer" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="aspect-[3/4] img-placeholder img-hover-zoom relative">
                        @if($leader->photo)
                            <img src="{{ asset('storage/' . $leader->photo) }}" alt="{{ $leader->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <div class="w-24 h-24 rounded-full bg-white/10 flex items-center justify-center">
                                    <span class="font-display font-bold text-4xl text-white/40">{{ substr($leader->name, 0, 1) }}</span>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="p-6">
                        <h3 class="text-slate-900 font-display font-semibold text-lg group-hover:text-blue-600 transition-colors">{{ $leader->name }}</h3>
                        <p class="text-blue-600 text-sm mt-1 font-medium">{{ $leader->title }}</p>
                        <div class="flex flex-wrap items-center gap-2 mt-3">
                            @if($leader->is_veteran)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-50 text-blue-600 text-xs font-medium">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                    {{ $leader->military_branch ?? 'Veteran' }}
                                </span>
                            @endif
                            <span class="text-slate-400 text-xs">{{ $leader->years_experience }}+ yrs</span>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-4 text-center py-20">
                    <p class="text-slate-400 text-lg">Leadership team profiles will be available soon.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection
