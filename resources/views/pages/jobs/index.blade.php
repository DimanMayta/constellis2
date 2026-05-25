@extends('layouts.app')
@section('title', 'Career Opportunities — Constellis')

@section('content')
{{-- Full-page watermark background --}}
<div class="relative">
    {{-- Fixed watermark image behind everything --}}
    <div class="fixed inset-0 z-0 pointer-events-none">
        <img src="{{ asset('images/careers.webp') }}" alt=""
             class="absolute inset-0 w-full h-full object-cover"
             loading="eager">
        <div class="absolute inset-0 bg-[#1d345d]/[0.88]"></div>
    </div>

<section class="relative py-28 overflow-hidden">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-[#9298af]/10 top-0 right-0 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-[#9298af] text-sm font-bold tracking-wider uppercase mb-4 block"
              x-text="$store.lang.current === 'en' ? 'Join Our Team' : 'Únete a Nuestro Equipo'"></span>
        <h1 class="section-heading-white mb-6"
            x-text="$store.lang.current === 'en' ? 'Career Opportunities' : 'Oportunidades Profesionales'"></h1>
        <p class="section-subheading-white mx-auto"
           x-text="$store.lang.current === 'en' ? 'Build a meaningful career with a team of dedicated professionals making a global impact' : 'Construye una carrera significativa con un equipo de profesionales dedicados generando un impacto global'"></p>
    </div>
</section>

<section class="relative -mt-10 pt-0 pb-16 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        {{-- Filters --}}
        <form method="GET" class="bg-white rounded-2xl p-6 mb-8 flex flex-wrap gap-4 items-end border border-slate-200 shadow-lg">
            <div class="flex-1 min-w-[200px]">
                <label class="block text-[#1d345d] text-sm font-bold mb-2"
                       x-text="$store.lang.current === 'en' ? 'Available Positions' : 'Puestos Disponibles'"></label>
                <input type="text" name="search" value="{{ request('search') }}"
                       x-bind:placeholder="$store.lang.current === 'en' ? 'Search available positions...' : 'Buscar puestos disponibles...'"
                       class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-[#1d345d] placeholder-slate-400 focus:border-[#e7333e] focus:ring-2 focus:ring-[#e7333e]/20 focus:outline-none transition-all">
            </div>
            <div class="w-48">
                <label class="block text-[#1d345d] text-sm font-bold mb-2"
                       x-text="$store.lang.current === 'en' ? 'Type' : 'Tipo'"></label>
                <select name="type" class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-[#1d345d] focus:border-[#e7333e] focus:ring-2 focus:ring-[#e7333e]/20 focus:outline-none transition-all">
                    <option value="" x-text="$store.lang.current === 'en' ? 'All Types' : 'Todos'"></option>
                    <option value="full-time" @selected(request('type') === 'full-time')
                            x-text="$store.lang.current === 'en' ? 'Full-Time' : 'Tiempo Completo'"></option>
                    <option value="part-time" @selected(request('type') === 'part-time')
                            x-text="$store.lang.current === 'en' ? 'Part-Time' : 'Medio Tiempo'"></option>
                    <option value="contract" @selected(request('type') === 'contract')
                            x-text="$store.lang.current === 'en' ? 'Contract' : 'Contrato'"></option>
                </select>
            </div>
            <button type="submit" class="inline-flex items-center gap-2 bg-[#e7333e] hover:bg-[#d42d37] text-white font-semibold px-6 py-3 rounded-xl transition-all duration-300 shadow-sm hover:shadow-md">
                <span x-text="$store.lang.current === 'en' ? 'Search' : 'Buscar'"></span>
            </button>
        </form>

        {{-- Job Listings --}}
        <div class="space-y-6">
            @forelse($jobs as $job)
                <div class="bg-white rounded-2xl p-6 sm:p-8 border border-slate-200 shadow-md hover:shadow-xl hover:border-[#e7333e]/30 transition-all duration-300 group" data-animate>
                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-[#1d345d]/10 text-[#1d345d] border border-[#1d345d]/20 capitalize"
                                      x-text="(() => { const t = '{{ $job->employment_type }}'; const map = {'full-time': {en:'Full Time',es:'Tiempo Completo'}, 'part-time': {en:'Part Time',es:'Medio Tiempo'}, 'contract': {en:'Contract',es:'Contrato'}}; return (map[t] || {en:t,es:t})[$store.lang.current] || t; })()"></span>
                                @if($job->clearance_level)<span class="px-3 py-1 rounded-full text-xs font-semibold bg-amber-50 text-amber-700 border border-amber-200">{{ $job->clearance_level }}</span>@endif
                                @if($job->department)<span class="px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-[#1d345d]">{{ $job->department }}</span>@endif
                            </div>
                            <h3 class="text-xl font-display font-semibold text-[#1d345d] group-hover:text-[#e7333e] transition-colors mb-2">
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
                            <a href="{{ route('jobs.show', $job) }}" class="inline-flex items-center justify-center gap-2 border-2 border-[#1d345d] text-[#1d345d] hover:bg-[#1d345d] hover:text-white font-semibold py-2.5 px-6 rounded-xl text-sm transition-all duration-300">
                                <span x-text="$store.lang.current === 'en' ? 'Details' : 'Detalles'"></span>
                            </a>
                            <a href="{{ route('jobs.apply', $job) }}" class="inline-flex items-center justify-center gap-2 bg-[#e7333e] hover:bg-[#d42d37] text-white font-semibold py-2.5 px-6 rounded-xl text-sm transition-all duration-300 shadow-sm">
                                <span x-text="$store.lang.current === 'en' ? 'Apply Now' : 'Aplicar Ahora'"></span>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-20">
                    <svg class="w-16 h-16 text-[#9298af]/50 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <p class="text-slate-400 text-lg"
                       x-text="$store.lang.current === 'en' ? 'No open positions at this time. Check back soon!' : 'No hay posiciones abiertas en este momento. ¡Vuelve pronto!'"></p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">{{ $jobs->links() }}</div>
    </div>
</section>

</div>{{-- end watermark wrapper --}}
@endsection
