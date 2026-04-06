@extends('layouts.app')
@section('title', $leader->name . ' — Constellis Leadership')

@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <a href="{{ route('about.leadership') }}" class="inline-flex items-center gap-2 text-blue-200 hover:text-white text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Leadership
        </a>
        <div class="flex flex-col md:flex-row items-start gap-8">
            <div class="w-28 h-28 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white shrink-0">
                <span class="font-display font-bold text-4xl">{{ substr($leader->name, 0, 1) }}</span>
            </div>
            <div>
                <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-2">{{ $leader->name }}</h1>
                <p class="text-blue-200 text-xl">{{ $leader->title }}</p>
                @if($leader->is_veteran)
                    <div class="flex items-center gap-2 mt-4">
                        <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-white/10 border border-white/20 text-white text-sm font-medium">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                            {{ $leader->military_branch }} — {{ $leader->rank }}
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-10">
                <div data-animate>
                    <h2 class="text-2xl font-display font-bold text-slate-900 mb-4">Professional Summary</h2>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                        {!! nl2br(e($leader->full_resume ?? $leader->bio)) !!}
                    </div>
                </div>

                @if($leader->specializations && count($leader->specializations))
                    <div data-animate>
                        <h2 class="text-2xl font-display font-bold text-slate-900 mb-4">Areas of Expertise</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($leader->specializations as $spec)
                                <span class="px-4 py-2 rounded-xl bg-blue-50 text-blue-700 text-sm font-medium border border-blue-100">{{ $spec }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($leader->countries_served && count($leader->countries_served))
                    <div data-animate>
                        <h2 class="text-2xl font-display font-bold text-slate-900 mb-4">Countries of Operation</h2>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-3">
                            @foreach($leader->countries_served as $country)
                                <div class="flex items-center gap-2 p-3 rounded-xl bg-slate-50 border border-slate-100">
                                    <div class="w-6 h-6 rounded bg-blue-100 flex items-center justify-center text-blue-700 font-bold text-xs">{{ substr($country, 0, 2) }}</div>
                                    <span class="text-slate-700 text-sm">{{ $country }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="card p-6" data-animate>
                    <h3 class="font-display font-semibold text-slate-900 mb-4">Quick Facts</h3>
                    <dl class="space-y-3">
                        <div class="flex justify-between"><dt class="text-slate-400 text-sm">Experience</dt><dd class="text-slate-900 font-semibold text-sm">{{ $leader->years_experience }}+ years</dd></div>
                        @if($leader->military_branch)<div class="flex justify-between"><dt class="text-slate-400 text-sm">Branch</dt><dd class="text-slate-900 font-semibold text-sm">{{ $leader->military_branch }}</dd></div>@endif
                        @if($leader->rank)<div class="flex justify-between"><dt class="text-slate-400 text-sm">Rank</dt><dd class="text-slate-900 font-semibold text-sm">{{ $leader->rank }}</dd></div>@endif
                        @if($leader->countries_served)<div class="flex justify-between"><dt class="text-slate-400 text-sm">Countries</dt><dd class="text-slate-900 font-semibold text-sm">{{ count($leader->countries_served) }}</dd></div>@endif
                    </dl>
                </div>

                @if($leader->education && count($leader->education))
                    <div class="card p-6" data-animate>
                        <h3 class="font-display font-semibold text-slate-900 mb-4">Education</h3>
                        <ul class="space-y-3">
                            @foreach($leader->education as $edu)
                                <li class="flex items-start gap-3">
                                    <div class="w-6 h-6 rounded bg-blue-50 flex items-center justify-center text-blue-600 mt-0.5 shrink-0">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/></svg>
                                    </div>
                                    <span class="text-slate-600 text-sm">{{ $edu }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if($leader->certifications && count($leader->certifications))
                    <div class="card p-6" data-animate>
                        <h3 class="font-display font-semibold text-slate-900 mb-4">Certifications</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($leader->certifications as $cert)
                                <span class="px-3 py-1 rounded-lg bg-green-50 text-green-700 text-xs font-medium border border-green-100">{{ $cert }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if($leader->linkedin_url)
                    <a href="{{ $leader->linkedin_url }}" target="_blank" rel="noopener" class="btn-outline w-full">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z"/></svg>
                        View LinkedIn Profile
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
