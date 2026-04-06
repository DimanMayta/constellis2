@extends('layouts.app')
@section('title', 'Who We Serve — Constellis')
@section('meta_description', 'Constellis provides comprehensive security solutions to the U.S. Government, Department of Defense, commercial enterprises, and international organizations.')

@section('content')

{{-- Hero --}}
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-0 right-0 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Our Customers</span>
        <h1 class="section-heading-white mb-6">Who We Serve</h1>
        <p class="section-subheading-white">Trusted by governments, agencies, and organizations across the globe to deliver mission-critical security solutions.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

{{-- Sectors --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">Sectors</span>
            <h2 class="section-heading mb-6">Serving Those Who <span class="gradient-text">Protect</span></h2>
            <p class="section-subheading mx-auto">Our customers span the full spectrum of security and defense, from federal agencies to multinational organizations.</p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            @php
                $sectors = [
                    [
                        'icon' => 'M3 21v-4m0 0V5a2 2 0 012-2h6.5l1 1H21l-3 6 3 6h-8.5l-1-1H5a2 2 0 00-2 2zm0 0h18',
                        'title' => 'U.S. Government',
                        'desc' => 'Constellis is a trusted partner to federal agencies, delivering security, intelligence, and technology solutions under multiple government contract vehicles. We support civilian agencies, the diplomatic community, and federal law enforcement.',
                        'stats' => ['20+ Agencies', 'Multiple IDIQs', 'CONUS & OCONUS'],
                    ],
                    [
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'title' => 'Department of Defense',
                        'desc' => 'We provide critical support to the U.S. military across all branches and combatant commands. From expeditionary operations to base security and training, our solutions are designed for the unique demands of defense missions.',
                        'stats' => ['All Service Branches', 'Forward Operations', 'Global Basing'],
                    ],
                    [
                        'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4',
                        'title' => 'Commercial & Critical Infrastructure',
                        'desc' => 'Major corporations, energy companies, and critical infrastructure operators trust Constellis to protect their people, assets, and operations. We deliver tailored security programs including K-9 services, access control, and technology solutions.',
                        'stats' => ['Energy Sector', 'Transportation', 'Healthcare Facilities'],
                    ],
                    [
                        'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                        'title' => 'International Organizations',
                        'desc' => 'Constellis operates across 35+ countries, supporting international organizations, NGOs, and allied governments with security, humanitarian demining, and training programs. Our global presence enables rapid deployment anywhere.',
                        'stats' => ['35+ Countries', 'UN & NGO Partners', 'Allied Governments'],
                    ],
                ];
            @endphp

            @foreach($sectors as $i => $sector)
                <div class="card p-8 group" data-animate style="animation-delay: {{ $i * 150 }}ms">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $sector['icon'] }}"/></svg>
                        </div>
                        <div>
                            <h3 class="text-slate-900 font-display font-bold text-xl mb-3 group-hover:text-blue-600 transition-colors">{{ $sector['title'] }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-5">{{ $sector['desc'] }}</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($sector['stats'] as $stat)
                                    <span class="inline-flex px-3 py-1 rounded-full bg-slate-50 border border-slate-100 text-slate-600 text-xs font-medium">{{ $stat }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="relative py-24 bg-slate-50 overflow-hidden">
    <div class="absolute inset-0 bg-mesh-2"></div>
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center" data-animate>
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold tracking-wider uppercase mb-8">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Partner With Us
        </div>
        <h2 class="section-heading mb-6">Ready to <span class="gradient-text">Get Started</span>?</h2>
        <p class="section-subheading mx-auto mb-10">
            Contact our team to discuss how Constellis can provide customized security, intelligence, and training solutions for your organization.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url('/contact') }}" class="btn-primary text-base px-10 py-4">
                Contact Us
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="{{ url('/contracts') }}" class="btn-outline text-base px-10 py-4">
                View Contract Vehicles
            </a>
        </div>
    </div>
</section>

@endsection
