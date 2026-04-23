@extends('layouts.app')
@section('title', 'Experience — Constellis')
@section('meta_description', 'Combined decades of military and security expertise across 35+ countries.')

@section('content')

{{-- Hero --}}
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[500px] h-[500px] bg-sky-400/10 -top-20 -right-20 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Our Strength</span>
        <h1 class="section-heading-white mb-6">Team Experience</h1>
        <p class="section-subheading-white mx-auto">A consolidated view of our team's unparalleled expertise and global reach</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

{{-- Key Stats --}}
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
            <div class="text-center" data-animate>
                <p class="text-5xl md:text-6xl font-display font-bold gradient-text mb-2" data-count="{{ $combinedYears }}" data-suffix="+">0+</p>
                <p class="text-slate-400 text-sm font-medium tracking-wide uppercase">Combined Years of Experience</p>
            </div>
            <div class="text-center" data-animate>
                <p class="text-5xl md:text-6xl font-display font-bold gradient-text mb-2" data-count="{{ count($countries) }}" data-suffix="+">0+</p>
                <p class="text-slate-400 text-sm font-medium tracking-wide uppercase">Countries Served</p>
            </div>
            <div class="text-center" data-animate>
                <p class="text-5xl md:text-6xl font-display font-bold gradient-text mb-2" data-count="{{ $veteranPercentage }}" data-suffix="%">0%</p>
                <p class="text-slate-400 text-sm font-medium tracking-wide uppercase">Veterans on Leadership Team</p>
            </div>
            <div class="text-center" data-animate>
                <p class="text-5xl md:text-6xl font-display font-bold gradient-text mb-2" data-count="{{ $totalLeaders }}">0</p>
                <p class="text-slate-400 text-sm font-medium tracking-wide uppercase">Executive Leaders</p>
            </div>
        </div>
    </div>
</section>

{{-- Veteran Heritage --}}
<section class="py-24 bg-slate-50 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div data-animate>
                <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">Heritage of Service</span>
                <h2 class="section-heading mb-8">Proud <span class="gradient-text">Veterans</span></h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    The vast majority of our executive leadership team are combat-decorated veterans who transitioned their military expertise into the private security sector.
                </p>
                <p class="text-slate-500 leading-relaxed mb-8">
                    Their service spans the U.S. Army, Navy, Marine Corps, Air Force, and Special Forces units — bringing unparalleled operational experience, leadership under pressure, and an unwavering commitment to mission success.
                </p>

                {{-- Military Branches --}}
                <div class="grid grid-cols-2 gap-4">
                    @foreach($leaders->where('is_veteran', true) as $vet)
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-white border border-slate-100">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-800 font-semibold text-xs">{{ $vet->name }}</p>
                                <p class="text-slate-400 text-xs">{{ $vet->military_branch ?? 'Veteran' }} — {{ $vet->rank ?? '' }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-2 gap-5" data-animate>
                <div class="glass-card p-8 text-center bg-gradient-to-br from-blue-600 to-blue-800 text-white rounded-3xl">
                    <p class="text-4xl font-display font-bold mb-2">{{ $totalVeterans }}/{{ $totalLeaders }}</p>
                    <p class="text-blue-200 text-sm">Veterans in Leadership</p>
                </div>
                <div class="card p-8 text-center">
                    <p class="text-4xl font-display font-bold gradient-text mb-2">5</p>
                    <p class="text-slate-400 text-sm">Military Branches</p>
                </div>
                <div class="card p-8 text-center">
                    <p class="text-4xl font-display font-bold gradient-text mb-2">{{ $combinedYears }}+</p>
                    <p class="text-slate-400 text-sm">Combined Years</p>
                </div>
                <div class="glass-card p-8 text-center bg-gradient-to-br from-sky-500 to-blue-700 text-white rounded-3xl">
                    <p class="text-4xl font-display font-bold mb-2">100%</p>
                    <p class="text-blue-200 text-sm">Veteran Commitment</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Countries Map --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">Global Reach</span>
            <h2 class="section-heading mb-6">Countries Where We've <span class="gradient-text">Operated</span></h2>
            <p class="section-subheading mx-auto">Our leadership has managed operations and delivered solutions across the globe</p>
        </div>

        <div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4" data-animate>
            @foreach($countries as $i => $country)
                <div class="flex items-center gap-3 p-4 rounded-xl bg-slate-50 border border-slate-100 hover:border-blue-200 hover:bg-blue-50 transition-all duration-300" style="animation-delay: {{ $i * 50 }}ms">
                    <div class="w-8 h-8 rounded-lg bg-blue-100 flex items-center justify-center text-blue-700 font-display font-bold text-xs">
                        {{ substr($country, 0, 2) }}
                    </div>
                    <span class="text-slate-700 font-medium text-sm">{{ $country }}</span>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Leadership Preview --}}
<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">The Team</span>
            <h2 class="section-heading mb-6">Executive <span class="gradient-text">Leadership</span></h2>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($leaders as $i => $leader)
                <a href="{{ route('about.leader', $leader) }}" class="card p-6 text-center group cursor-pointer" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center mx-auto mb-4 text-blue-600 group-hover:from-blue-600 group-hover:to-blue-700 group-hover:text-white transition-all duration-300">
                        <span class="font-display font-bold text-2xl">{{ substr($leader->name, 0, 1) }}</span>
                    </div>
                    <h3 class="text-slate-900 font-display font-semibold group-hover:text-blue-600 transition-colors">{{ $leader->name }}</h3>
                    <p class="text-slate-400 text-sm mt-1">{{ $leader->title }}</p>
                    @if($leader->is_veteran)
                        <span class="inline-flex items-center gap-1 px-2 py-1 rounded-full bg-blue-50 text-blue-600 text-xs font-medium mt-3">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            {{ $leader->military_branch ?? 'Veteran' }}
                        </span>
                    @endif
                    <p class="text-slate-400 text-xs mt-2">{{ $leader->years_experience }}+ years experience</p>
                </a>
            @endforeach
        </div>

        <div class="text-center mt-12">
            <a href="{{ route('about.leadership') }}" class="btn-primary">View Full Team</a>
        </div>
    </div>
</section>

@endsection
