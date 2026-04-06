@extends('layouts.app')
@section('title', 'Career Opportunities — Constellis')

@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-0 right-0 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Join Our Team</span>
        <h1 class="section-heading-white mb-6">Career Opportunities</h1>
        <p class="section-subheading-white mx-auto">Build a meaningful career with a team of dedicated professionals making a global impact</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Filters --}}
        <form method="GET" class="card p-6 mb-12 flex flex-wrap gap-4 items-end">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Location</label>
                <input type="text" name="location" value="{{ request('location') }}" placeholder="Search by location..."
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
            </div>
            <div class="w-48">
                <label class="block text-slate-700 text-sm font-semibold mb-2">Type</label>
                <select name="type" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                    <option value="">All Types</option>
                    <option value="full-time" @selected(request('type') === 'full-time')>Full-Time</option>
                    <option value="part-time" @selected(request('type') === 'part-time')>Part-Time</option>
                    <option value="contract" @selected(request('type') === 'contract')>Contract</option>
                </select>
            </div>
            <button type="submit" class="btn-primary py-3">Search</button>
        </form>

        {{-- Job Listings --}}
        <div class="space-y-6">
            @forelse($jobs as $job)
                <div class="card p-6 sm:p-8 group hover:border-blue-200 transition-all" data-animate>
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 border border-blue-200 capitalize">{{ str_replace('-', ' ', $job->employment_type) }}</span>
                                @if($job->clearance_level)<span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">{{ $job->clearance_level }}</span>@endif
                                @if($job->department)<span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">{{ $job->department }}</span>@endif
                            </div>
                            <h3 class="text-xl font-display font-semibold text-slate-900 group-hover:text-blue-600 transition-colors mb-2">
                                <a href="{{ route('jobs.show', $job) }}">{{ $job->title }}</a>
                            </h3>
                            <p class="text-slate-500 text-sm mb-3">{{ Str::limit($job->description, 200) }}</p>
                            <div class="flex flex-wrap items-center gap-4 text-xs text-slate-400">
                                <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>{{ $job->location }}</span>
                                @if($job->salary_range)<span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8V7m0 1v8m0 0v1"/></svg>{{ $job->salary_range }}</span>@endif
                                @if($job->project)<span class="flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16"/></svg>{{ $job->project->name }}</span>@endif
                            </div>
                        </div>
                        <div class="flex gap-3 sm:flex-col">
                            <a href="{{ route('jobs.show', $job) }}" class="btn-outline py-2.5 px-6 text-sm">Details</a>
                            <a href="{{ route('jobs.apply', $job) }}" class="btn-primary py-2.5 px-6 text-sm">Apply Now</a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <p class="text-slate-400 text-lg">No open positions at this time. Check back soon!</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $jobs->links() }}</div>
    </div>
</section>
@endsection
