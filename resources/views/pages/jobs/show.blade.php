@extends('layouts.app')
@section('title', $job->title . ' — Constellis Careers')

@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-[#1d345d] via-[#253d6a] to-[#1d345d]">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <a href="{{ route('jobs.index') }}" class="inline-flex items-center gap-2 text-[#9298af] hover:text-white text-sm font-medium mb-8 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span x-text="$store.lang.current === 'en' ? 'All Positions' : 'Todas las Posiciones'"></span>
        </a>
        <h1 class="text-4xl md:text-5xl font-display font-bold text-white mb-4">{{ $job->title }}</h1>
        <div class="flex flex-wrap items-center gap-3 mt-4">
            <span class="px-3 py-1 rounded-full text-xs font-semibold bg-white/10 text-white border border-white/20 capitalize"
                  x-text="(() => { const t = '{{ $job->employment_type }}'; const map = {'full-time': {en:'Full Time',es:'Tiempo Completo'}, 'part-time': {en:'Part Time',es:'Medio Tiempo'}, 'contract': {en:'Contract',es:'Contrato'}}; return (map[t] || {en:t,es:t})[$store.lang.current] || t; })()"></span>
            <span class="text-[#9298af] text-sm">📍 {{ $job->location }}</span>
            @if($job->salary_range)<span class="text-[#9298af] text-sm">💰 {{ $job->salary_range }}</span>@endif
        </div>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="#eff6ef"/></svg></div>
</section>

@if(session('success'))
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-8">
        <div class="bg-green-50 rounded-2xl p-6 border border-green-200">
            <div class="flex items-center gap-3">
                <svg class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-green-800 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    </div>
@endif

<section class="py-16 bg-[#eff6ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-12">
            <div class="lg:col-span-2 space-y-8">
                <div class="bg-white rounded-2xl p-8 border border-[#9298af]/20 shadow-sm">
                    <h2 class="text-2xl font-display font-bold text-[#1d345d] mb-4"
                        x-text="$store.lang.current === 'en' ? 'Position Overview' : 'Descripción del Puesto'"></h2>
                    <div class="prose max-w-none text-[#9298af]">{!! nl2br(e($job->description)) !!}</div>
                </div>
                @if($job->requirements)
                    <div class="bg-white rounded-2xl p-8 border border-[#9298af]/20 shadow-sm">
                        <h2 class="text-2xl font-display font-bold text-[#1d345d] mb-4"
                            x-text="$store.lang.current === 'en' ? 'Requirements' : 'Requisitos'"></h2>
                        <div class="prose max-w-none text-[#9298af]">{!! nl2br(e($job->requirements)) !!}</div>
                    </div>
                @endif
                @if($job->responsibilities)
                    <div class="bg-white rounded-2xl p-8 border border-[#9298af]/20 shadow-sm">
                        <h2 class="text-2xl font-display font-bold text-[#1d345d] mb-4"
                            x-text="$store.lang.current === 'en' ? 'Responsibilities' : 'Responsabilidades'"></h2>
                        <div class="prose max-w-none text-[#9298af]">{!! nl2br(e($job->responsibilities)) !!}</div>
                    </div>
                @endif
            </div>

            <div class="space-y-6">
                <div class="bg-white rounded-2xl p-6 border border-[#9298af]/20 shadow-sm sticky top-28">
                    <h3 class="font-display font-semibold text-[#1d345d] mb-4"
                        x-text="$store.lang.current === 'en' ? 'Position Details' : 'Detalles del Puesto'"></h3>
                    <dl class="space-y-3 mb-6">
                        <div>
                            <dt class="text-[#9298af] text-xs uppercase"
                                x-text="$store.lang.current === 'en' ? 'Department' : 'Departamento'"></dt>
                            <dd class="text-[#1d345d] font-medium text-sm mt-1">{{ $job->department ?? 'General' }}</dd>
                        </div>
                        <div>
                            <dt class="text-[#9298af] text-xs uppercase"
                                x-text="$store.lang.current === 'en' ? 'Location' : 'Ubicación'"></dt>
                            <dd class="text-[#1d345d] font-medium text-sm mt-1">{{ $job->location }}</dd>
                        </div>
                        <div>
                            <dt class="text-[#9298af] text-xs uppercase"
                                x-text="$store.lang.current === 'en' ? 'Type' : 'Tipo'"></dt>
                            <dd class="text-[#1d345d] font-medium text-sm mt-1 capitalize"
                                x-text="(() => { const t = '{{ $job->employment_type }}'; const map = {'full-time': {en:'Full Time',es:'Tiempo Completo'}, 'part-time': {en:'Part Time',es:'Medio Tiempo'}, 'contract': {en:'Contract',es:'Contrato'}}; return (map[t] || {en:t,es:t})[$store.lang.current] || t; })()"></dd>
                        </div>
                        @if($job->clearance_level)
                        <div>
                            <dt class="text-[#9298af] text-xs uppercase"
                                x-text="$store.lang.current === 'en' ? 'Clearance' : 'Habilitación'"></dt>
                            <dd class="text-[#1d345d] font-medium text-sm mt-1">{{ $job->clearance_level }}</dd>
                        </div>
                        @endif
                        @if($job->salary_range)
                        <div>
                            <dt class="text-[#9298af] text-xs uppercase"
                                x-text="$store.lang.current === 'en' ? 'Salary' : 'Salario'"></dt>
                            <dd class="text-[#1d345d] font-medium text-sm mt-1">{{ $job->salary_range }}</dd>
                        </div>
                        @endif
                        @if($job->project)
                        <div>
                            <dt class="text-[#9298af] text-xs uppercase"
                                x-text="$store.lang.current === 'en' ? 'Reference Project' : 'Proyecto de Referencia'"></dt>
                            <dd class="text-[#1d345d] font-medium text-sm mt-1">{{ $job->project->name }}</dd>
                        </div>
                        @endif
                    </dl>
                    <a href="{{ route('jobs.apply', $job) }}" class="flex items-center justify-center gap-2 w-full bg-[#e7333e] hover:bg-[#d42d37] text-white font-semibold py-3.5 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                        <span x-text="$store.lang.current === 'en' ? 'Apply Now' : 'Aplicar Ahora'"></span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <p class="text-[#9298af] text-xs text-center mt-3"
                       x-text="$store.lang.current === 'en' ? 'Required documents: CV, NDA, Application Form' : 'Documentos requeridos: CV, NDA, Formulario de Aplicación'"></p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
