@extends('layouts.app')
@section('title', $job->title . ' — Constellis Careers')

@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-blue-200 hover:text-white text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            All Positions
        </a>
        <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">{{ $job->title }}</h1>
        <div class="flex flex-wrap items-center gap-3 mt-4">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-white border border-white/20 capitalize">{{ str_replace('-', ' ', $job->employment_type) }}</span>
            <span class="text-blue-200 text-sm">📍 {{ $job->location }}</span>
            @if($job->salary_range)<span class="text-blue-200 text-sm">💰 {{ $job->salary_range }}</span>@endif
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="card p-6 border-green-200 bg-green-50">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-8">
                <div class="card p-8">
                    <h2 class="text-2xl font-display font-bold text-slate-900 mb-4">Position Overview</h2>
                    <div class="prose prose-slate max-w-none text-slate-600">{!! nl2br(e($job->description)) !!}</div>
                </div>
                @if($job->requirements)
                    <div class="card p-8">
                        <h2 class="text-2xl font-display font-bold text-slate-900 mb-4">Requirements</h2>
                        <div class="prose prose-slate max-w-none text-slate-600">{!! nl2br(e($job->requirements)) !!}</div>
                    </div>
                @endif
                @if($job->responsibilities)
                    <div class="card p-8">
                        <h2 class="text-2xl font-display font-bold text-slate-900 mb-4">Responsibilities</h2>
                        <div class="prose prose-slate max-w-none text-slate-600">{!! nl2br(e($job->responsibilities)) !!}</div>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="card p-6 sticky top-28">
                    <h3 class="font-display font-semibold text-slate-900 mb-4">Position Details</h3>
                    <dl class="space-y-3 mb-6">
                        <div><dt class="text-slate-400 text-xs uppercase">Department</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $job->department ?? 'General' }}</dd></div>
                        <div><dt class="text-slate-400 text-xs uppercase">Location</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $job->location }}</dd></div>
                        <div><dt class="text-slate-400 text-xs uppercase">Type</dt><dd class="text-slate-900 font-medium text-sm mt-1 capitalize">{{ str_replace('-', ' ', $job->employment_type) }}</dd></div>
                        @if($job->clearance_level)<div><dt class="text-slate-400 text-xs uppercase">Clearance</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $job->clearance_level }}</dd></div>@endif
                        @if($job->salary_range)<div><dt class="text-slate-400 text-xs uppercase">Salary</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $job->salary_range }}</dd></div>@endif
                        @if($job->project)<div><dt class="text-slate-400 text-xs uppercase">Reference Project</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $job->project->name }}</dd></div>@endif
                    </dl>
                    <a href="{{ route('jobs.apply', $job) }}" class="btn-primary w-full">
                        Apply Now
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <p class="text-slate-400 text-xs text-center mt-3">Required documents: CV, NDA, Application Form</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
