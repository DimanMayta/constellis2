@extends('layouts.app')
@section('title', 'Our Divisions — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Who We Are</span>
        <h1 class="section-heading-white mb-6">Our Divisions</h1>
        <p class="section-subheading-white">Constellis operates through a family of specialized brands, each with a proven track record of excellence.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($divisions ?? [] as $i => $division)
                <div class="card p-8 group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-6 font-display font-bold text-xl group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300">
                        {{ substr($division->name, 0, 2) }}
                    </div>
                    <h3 class="text-slate-900 font-display font-semibold text-xl mb-3 group-hover:text-blue-600 transition-colors">{{ $division->name }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $division->description ?? 'Specialized division delivering mission-critical services worldwide.' }}</p>
                </div>
            @empty
                @foreach(['Triple Canopy' => 'Elite protective services and security solutions for government and commercial clients.', 'Centerra' => 'Comprehensive security services for critical infrastructure and government facilities.', 'AMK9' => 'World-class explosive and narcotic detection K-9 services.', 'Olive Group' => 'International security and risk management consulting.', 'Omniplex' => 'Specialized investigation and compliance services.', 'Academi' => 'Advanced training and education programs.'] as $name => $desc)
                    <div class="card p-8 group" data-animate>
                        <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-6 font-display font-bold text-xl group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300">{{ substr($name, 0, 2) }}</div>
                        <h3 class="text-slate-900 font-display font-semibold text-xl mb-3 group-hover:text-blue-600 transition-colors">{{ $name }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
@endsection
