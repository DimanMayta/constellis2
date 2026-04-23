@extends('layouts.app')
@section('title', 'Projects — Constellis')

@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Active Operations</span>
        <h1 class="section-heading-white mb-6">Our Projects</h1>
        <p class="section-subheading-white mx-auto">Global security projects across multiple continents and domains</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

@if(session('error'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="card p-4 border-red-200 bg-red-50">
            <p class="text-red-800 text-sm font-medium">{{ session('error') }}</p>
        </div>
    </div>
@endif

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8" x-data="{ activeModal: null }">
            @foreach($projects as $i => $project)
                <div class="card overflow-hidden group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    {{-- Status Badge + Progress --}}
                    <div class="p-6 pb-0">
                        <div class="flex items-center justify-between mb-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                {{ $project->status === 'completed' ? 'bg-green-50 text-green-700 border border-green-200' :
                                   ($project->status === 'active' ? 'bg-blue-50 text-blue-700 border border-blue-200' :
                                   'bg-amber-50 text-amber-700 border border-amber-200') }}">
                                {{ $project->status_badge }}
                            </span>
                            <span class="text-slate-400 text-xs font-medium">{{ $project->country }}</span>
                        </div>

                        <h3 class="text-slate-900 font-display font-semibold text-lg mb-2">{{ $project->name }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed mb-4 line-clamp-2">{{ $project->description }}</p>

                        {{-- Progress Bar --}}
                        <div class="mb-2">
                            <div class="flex justify-between text-xs mb-1">
                                <span class="text-slate-400">Progress</span>
                                <span class="text-blue-600 font-semibold">{{ $project->progress_percentage }}%</span>
                            </div>
                            <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-600 rounded-full transition-all duration-1000" style="width: {{ $project->progress_percentage }}%"></div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 text-xs text-slate-400 mb-4">
                            <span>📍 {{ $project->location }}</span>
                            @if($project->start_date)
                                <span>📅 {{ $project->start_date->format('M Y') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Access Button --}}
                    <div class="p-6 pt-0">
                        <button @click="activeModal = {{ $project->id }}" class="btn-outline w-full text-sm py-3">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            View Details
                        </button>
                    </div>

                    {{-- Access Code Modal --}}
                    <div x-show="activeModal === {{ $project->id }}" x-transition
                         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm"
                         @click.self="activeModal = null">
                        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full" @click.stop>
                            <div class="text-center mb-6">
                                <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mx-auto mb-4">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                                </div>
                                <h3 class="font-display font-bold text-xl text-slate-900">Access Project Details</h3>
                                <p class="text-slate-400 text-sm mt-2">Enter the access code provided by your project manager</p>
                            </div>
                            <form action="{{ route('projects.authenticate', $project) }}" method="POST">
                                @csrf
                                <input type="password" name="access_code" placeholder="Enter access code" required
                                       class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all mb-4">
                                @if($errors->has('access_code'))
                                    <p class="text-red-500 text-xs mb-4">{{ $errors->first('access_code') }}</p>
                                @endif
                                <div class="flex gap-3">
                                    <button type="button" @click="activeModal = null" class="btn-outline flex-1 py-3">Cancel</button>
                                    <button type="submit" class="btn-primary flex-1 py-3">Unlock</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
