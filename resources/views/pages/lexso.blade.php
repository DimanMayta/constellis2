@extends('layouts.app')
@section('title', 'LEXSO™ — Law Enforcement & Security Operations Platform — Constellis')
@section('meta_description', 'LEXSO™ is Constellis\' mission-adaptive platform designed to integrate sensors, AI, and decision engines into a single operational network for real-time awareness.')

@section('content')

{{-- ============================================================
     HERO — LEXSO Brand Hero
     ============================================================ --}}
<section class="relative min-h-[70vh] flex items-center overflow-hidden -mt-20 pt-20" id="lexso-hero">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-blue-900 to-blue-800"></div>
    <div class="absolute inset-0 line-grid opacity-30"></div>

    {{-- Animated orbit rings --}}
    <div class="orbit-ring w-[500px] h-[500px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-20" style="animation-duration:35s"></div>
    <div class="orbit-ring w-[750px] h-[750px] top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 opacity-10" style="animation-duration:55s; animation-direction:reverse"></div>

    {{-- Morphing blobs --}}
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-10 right-0 animate-morph"></div>
    <div class="blob w-[300px] h-[300px] bg-blue-300/8 bottom-0 left-10 animate-morph" style="animation-delay:-4s"></div>

    {{-- Floating shapes --}}
    <div class="floating-shape top-1/4 right-[12%] w-16 h-16 border-2 border-white/10 rounded-xl rotate-12"></div>
    <div class="floating-shape bottom-1/3 left-[15%] w-10 h-10 border border-white/8 rounded-full" style="animation-delay:-3s"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-28">
        <div class="max-w-3xl">
            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold tracking-wider uppercase mb-8 animate-fade-in">
                <span class="w-2 h-2 rounded-full bg-sky-300 animate-pulse"></span>
                Technology Platform
            </div>

            <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold text-white leading-[1.08] mb-8 animate-fade-in-up">
                LEXSO<span class="gradient-text-white">™</span>
            </h1>

            <p class="text-xl md:text-2xl text-blue-100/90 leading-relaxed mb-6 animate-fade-in-up delay-200">
                Open Architecture. Real-Time Awareness.
            </p>

            <p class="text-lg text-blue-200/70 leading-relaxed mb-12 max-w-2xl animate-fade-in-up delay-300">
                At the core of LEXSO™ is a mission-adaptive platform — designed to integrate sensors, AI, and decision engines into a single operational network. Whether fixed, mobile, or hybrid, we architect secure, real-time ecosystems built for your mission profile.
            </p>

            <div class="flex flex-wrap gap-4 animate-fade-in-up delay-400">
                <a href="{{ url('/contact') }}" class="btn-white">
                    Contact Our Team
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
                <a href="#capabilities" class="btn-outline-white">
                    Explore Capabilities
                </a>
            </div>
        </div>
    </div>

    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full"><path d="M0 120V60C240 20 480 0 720 20C960 40 1200 60 1440 40V120H0Z" fill="white"/></svg>
    </div>
</section>

{{-- ============================================================
     PLATFORM OVERVIEW
     ============================================================ --}}
<section class="relative py-24 bg-white" id="capabilities">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            <div data-animate>
                <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">Platform Overview</span>
                <h2 class="section-heading mb-8">
                    Unified <span class="gradient-text">Technology</span> Ecosystem
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    LEXSO™ is a powerful, open-architecture platform engineered to unify diverse technologies into a single, responsive ecosystem. We deliver advanced technology services that enable real-time situational awareness, multi-sensor data fusion, and autonomous operational workflows.
                </p>
                <p class="text-slate-500 leading-relaxed mb-8">
                    Our team specializes in rapid integration, secure network design, and AI-driven automation that enhances decision-making at the speed of sensing. From cloud-native infrastructure to edge compute deployments, we ensure high performance, secure interoperability, and resilient command-and-control.
                </p>

                <div class="grid grid-cols-2 gap-4">
                    @foreach(['AI-Driven Analytics', 'Multi-Sensor Fusion', 'Open Architecture', 'Edge Computing', '24/7/365 Support', 'Tech Agnostic'] as $feature)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-slate-700 font-medium text-sm">{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Visual side --}}
            <div class="relative" data-animate>
                <div class="relative z-10">
                    <div class="rounded-3xl overflow-hidden shadow-blue-lg img-hover-zoom">
                        <div class="img-placeholder aspect-[4/3]">
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <div class="text-center">
                                    <svg class="w-16 h-16 text-white/30 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    <p class="text-white/40 font-display font-semibold text-sm tracking-wider uppercase">LEXSO™ Platform</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating card --}}
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-5 animate-float z-20">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-900 font-display font-bold text-lg">Real-Time</p>
                                <p class="text-slate-400 text-xs">AI-Powered Analysis</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute -top-4 -left-4 w-24 h-24 dot-grid rounded-2xl"></div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     CAPABILITIES GRID
     ============================================================ --}}
<section class="relative py-28 bg-slate-50" id="lexso-capabilities">
    <div class="absolute inset-0 bg-mesh-1"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center mb-16" data-animate>
            <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">Core Capabilities</span>
            <h2 class="section-heading mb-6">
                Integrated <span class="gradient-text">Solutions</span>
            </h2>
            <p class="section-subheading mx-auto">
                From sensor integration to API connectivity, LEXSO™ delivers a complete technology ecosystem for mission-critical operations.
            </p>
        </div>

        <div class="grid md:grid-cols-2 gap-8">
            @php
                $capabilities = [
                    [
                        'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z',
                        'title' => 'Sensor Integration',
                        'desc' => 'LEXSO™ delivers an unmatched sensor integration framework, capable of incorporating LIDAR, radar, thermal cameras, motion detectors, and acoustic/seismic sensors. Each sensor is carefully selected, tested, and calibrated to match the mission\'s specific threat profile.',
                        'features' => ['LIDAR & Radar', 'Thermal Cameras', 'Acoustic/Seismic Sensors', 'Legacy System Integration'],
                    ],
                    [
                        'icon' => 'M12 19l9 2-9-18-9 18 9-2zm0 0v-8',
                        'title' => 'UAS & cUAS Integration',
                        'desc' => 'Seamlessly integrates Unmanned Aerial Systems and Counter-UAS capabilities for proactive surveillance and reactive deterrence in real time. UAS platforms can be launched automatically based on sensor triggers or scheduled patrols.',
                        'features' => ['Multi-Payload Drones', 'Automated Launch', 'RF Detection', 'Airspace Defense'],
                    ],
                    [
                        'icon' => 'M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4',
                        'title' => 'API Integration',
                        'desc' => 'Built with robust, developer-friendly APIs that enable rapid, secure integration with third-party systems. We support RESTful, TCP/UDP, and event-driven integrations ensuring low-latency data exchange across sensors and decision engines.',
                        'features' => ['RESTful APIs', 'TCP/UDP Support', 'Sandbox Environments', 'API-ICD Documentation'],
                    ],
                    [
                        'icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                        'title' => 'Advisory & Lifecycle Support',
                        'desc' => 'Full lifecycle support from architecture and design to field testing and sustainment. Continuous monitoring, software updates, and technical assistance 24/7/365 ensure your operations remain mission ready.',
                        'features' => ['Architecture Design', 'Field Testing', 'Continuous Monitoring', '24/7/365 Support'],
                    ],
                ];
            @endphp

            @foreach($capabilities as $i => $cap)
                <div class="card p-8 group" data-animate style="animation-delay: {{ $i * 150 }}ms">
                    <div class="flex items-start gap-5">
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shrink-0 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $cap['icon'] }}"/></svg>
                        </div>
                        <div>
                            <h3 class="text-slate-900 font-display font-semibold text-xl mb-3 group-hover:text-blue-600 transition-colors">{{ $cap['title'] }}</h3>
                            <p class="text-slate-500 text-sm leading-relaxed mb-5">{{ $cap['desc'] }}</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($cap['features'] as $feat)
                                    <span class="inline-flex px-3 py-1 rounded-full bg-blue-50 border border-blue-100 text-blue-700 text-xs font-medium">{{ $feat }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     CTA
     ============================================================ --}}
<section class="relative py-28 overflow-hidden" id="lexso-cta">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900"></div>
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-0 right-0 animate-morph"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" data-animate>
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-bold tracking-wider uppercase mb-8">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Get Started with LEXSO™
        </div>
        <h2 class="section-heading-white mb-6">Ready to Modernize Your Operations?</h2>
        <p class="text-blue-100/80 text-lg leading-relaxed mb-10 max-w-2xl mx-auto">
            Whether planning a new security strategy or optimizing an existing one, LEXSO™ delivers the guidance and technical insight organizations need to stay ahead of evolving threats.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url('/contact') }}" class="btn-white text-base px-10 py-4">
                Contact Our Team
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="tel:18663491506" class="btn-outline-white text-base px-10 py-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Call Us Now
            </a>
        </div>
    </div>
</section>

@endsection
