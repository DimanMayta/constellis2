@extends('layouts.app')
@section('title', $project->name . ' — Constellis Projects')

@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <a href="{{ route('projects.index') }}" class="inline-flex items-center gap-2 text-blue-200 hover:text-white text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Projects
        </a>
        <div class="flex flex-wrap items-center gap-4 mb-4">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 border border-white/20 text-white">{{ $project->code_name }}</span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $project->status === 'completed' ? 'bg-green-400/20 text-green-200' : ($project->status === 'active' ? 'bg-blue-400/20 text-blue-200' : 'bg-amber-400/20 text-amber-200') }}">{{ $project->status_badge }}</span>
        </div>
        <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">{{ $project->name }}</h1>
        <p class="text-blue-200 text-lg max-w-2xl">{{ $project->description }}</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Stats Row --}}
        <div class="grid grid-cols-2 md:grid-cols-5 gap-6 mb-16">
            <div class="card p-6 text-center"><p class="text-3xl font-display font-bold gradient-text">{{ $project->progress_percentage }}%</p><p class="text-slate-400 text-xs mt-1">Progress</p></div>
            <div class="card p-6 text-center"><p class="text-lg font-display font-bold text-slate-900">{{ $project->location }}</p><p class="text-slate-400 text-xs mt-1">Location</p></div>
            <div class="card p-6 text-center"><p class="text-lg font-display font-bold text-slate-900">{{ $project->country }}</p><p class="text-slate-400 text-xs mt-1">Country</p></div>
            <div class="card p-6 text-center"><p class="text-lg font-display font-bold text-slate-900">{{ $project->start_date?->format('M Y') ?? 'TBD' }}</p><p class="text-slate-400 text-xs mt-1">Start Date</p></div>
            <div class="card p-6 text-center"><p class="text-lg font-display font-bold text-slate-900">${{ number_format($project->budget / 1000000, 1) }}M</p><p class="text-slate-400 text-xs mt-1">Budget</p></div>
        </div>

        <div class="grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-8">
                {{-- Progress Bar --}}
                <div class="card p-6">
                    <h3 class="font-display font-semibold text-slate-900 mb-4">Project Progress</h3>
                    <div class="w-full h-4 bg-slate-100 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-1000" style="width: {{ $project->progress_percentage }}%"></div>
                    </div>
                    <p class="text-slate-400 text-sm mt-2">{{ $project->progress_percentage }}% complete</p>
                </div>

                {{-- Details --}}
                <div class="card p-8">
                    <h3 class="font-display font-semibold text-slate-900 text-xl mb-4">Project Details</h3>
                    <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                        {!! nl2br(e($project->details ?? 'Detailed project information will be updated as the project progresses.')) !!}
                    </div>
                </div>

                {{-- Milestones --}}
                @if($project->milestones && count($project->milestones))
                    <div class="card p-8">
                        <h3 class="font-display font-semibold text-slate-900 text-xl mb-6">Milestones</h3>
                        <div class="space-y-4">
                            @foreach($project->milestones as $milestone)
                                <div class="flex items-start gap-4 p-4 rounded-xl bg-slate-50">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center text-blue-600 shrink-0">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div>
                                        <p class="text-slate-900 font-semibold text-sm">{{ $milestone['title'] ?? $milestone }}</p>
                                        @if(isset($milestone['date']))<p class="text-slate-400 text-xs mt-1">{{ $milestone['date'] }}</p>@endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <div class="card p-6">
                    <h3 class="font-display font-semibold text-slate-900 mb-4">Project Info</h3>
                    <dl class="space-y-3">
                        <div><dt class="text-slate-400 text-xs uppercase tracking-wide">Client</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $project->client ?? 'Classified' }}</dd></div>
                        <div><dt class="text-slate-400 text-xs uppercase tracking-wide">Code Name</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $project->code_name }}</dd></div>
                        <div><dt class="text-slate-400 text-xs uppercase tracking-wide">Status</dt><dd class="mt-1"><span class="px-2 py-1 rounded text-xs font-semibold {{ $project->status === 'active' ? 'bg-blue-50 text-blue-700' : 'bg-green-50 text-green-700' }}">{{ $project->status_badge }}</span></dd></div>
                        @if($project->end_date)<div><dt class="text-slate-400 text-xs uppercase tracking-wide">Target Completion</dt><dd class="text-slate-900 font-medium text-sm mt-1">{{ $project->end_date->format('M d, Y') }}</dd></div>@endif
                    </dl>
                </div>
                <a href="{{ route('projects.index') }}" class="btn-outline w-full">← Back to All Projects</a>
            </div>
        </div>
    </div>
</section>
@endsection
