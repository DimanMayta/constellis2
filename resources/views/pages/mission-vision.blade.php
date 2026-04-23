@extends('layouts.app')
@section('title', 'Mission & Vision — Constellis')
@section('meta_description', 'Discover Constellis mission and strategic vision for global security excellence.')

@section('content')

{{-- Hero --}}
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-0 right-0 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Our Foundation</span>
        <h1 class="section-heading-white mb-6">Mission & Vision</h1>
        <p class="section-subheading-white mx-auto">Guiding principles that drive our commitment to global security excellence</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

{{-- Mission & Vision Split --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-2 gap-16">
            {{-- Mission --}}
            <div class="relative" data-animate>
                <div class="absolute -top-4 -left-4 w-20 h-20 bg-blue-50 rounded-3xl -z-10"></div>
                <div class="card p-10 border-l-4 border-l-blue-600 h-full">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-600 mb-8">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h2 class="text-3xl font-display font-bold text-slate-900 mb-6">Our Mission</h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-6">
                        To deliver end-to-end risk management and comprehensive security solutions that safeguard people, infrastructure, and critical assets across the globe.
                    </p>
                    <p class="text-slate-500 leading-relaxed">
                        We accomplish this through the deployment of highly trained, impact-driven professionals who navigate our customers through diverse and challenging environments, leveraging decades of combined military and security expertise to ensure operational success.
                    </p>
                </div>
            </div>

            {{-- Vision --}}
            <div class="relative" data-animate>
                <div class="absolute -top-4 -right-4 w-20 h-20 bg-sky-50 rounded-3xl -z-10"></div>
                <div class="card p-10 border-l-4 border-l-sky-500 h-full">
                    <div class="w-16 h-16 rounded-2xl bg-sky-50 flex items-center justify-center text-sky-600 mb-8">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    </div>
                    <h2 class="text-3xl font-display font-bold text-slate-900 mb-6">Our Vision</h2>
                    <p class="text-slate-600 text-lg leading-relaxed mb-6">
                        To be the world's most trusted and innovative provider of integrated security, intelligence, and training solutions — setting the standard for excellence in every environment we operate.
                    </p>
                    <p class="text-slate-500 leading-relaxed">
                        We envision a future where our technology-driven approach and unparalleled human expertise create safer communities, protect vital interests, and enable our partners to achieve their objectives with confidence and peace of mind.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Core Values --}}
<section class="py-24 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">Our Foundation</span>
            <h2 class="section-heading mb-6">Core <span class="gradient-text">Values</span></h2>
            <p class="section-subheading mx-auto">The principles that define who we are and guide every decision we make</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $values = [
                    ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'title' => 'Integrity', 'desc' => 'We operate with unwavering ethical standards and transparency in every engagement.'],
                    ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'title' => 'Teamwork', 'desc' => 'Our strength comes from the diverse backgrounds and unified purpose of our global team.'],
                    ['icon' => 'M13 10V3L4 14h7v7l9-11h-7z', 'title' => 'Innovation', 'desc' => 'We continuously evolve our capabilities to meet emerging threats and challenges.'],
                    ['icon' => 'M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z', 'title' => 'Excellence', 'desc' => 'We pursue the highest standards in training, operations, and client service.'],
                ];
            @endphp
            @foreach($values as $i => $v)
                <div class="card p-8 text-center group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mx-auto mb-6 group-hover:bg-blue-600 group-hover:text-white group-hover:border-blue-600 transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $v['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-slate-900 font-display font-bold text-xl mb-3">{{ $v['title'] }}</h3>
                    <p class="text-slate-500 text-sm leading-relaxed">{{ $v['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Strategic Principles --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-3 gap-8">
            @php
                $principles = [
                    ['title' => 'People First', 'desc' => 'Our veterans and security professionals are our greatest asset. We invest in their development, well-being, and career growth — because their success is our clients\' success.', 'gradient' => 'from-blue-600 to-blue-800'],
                    ['title' => 'Global Reach', 'desc' => 'Operating in 35+ countries, we bring local knowledge and cultural expertise to every mission. Our network ensures rapid deployment and seamless execution worldwide.', 'gradient' => 'from-sky-500 to-blue-700'],
                    ['title' => 'Future Ready', 'desc' => 'From AI-powered threat detection to advanced drone systems, we continuously integrate cutting-edge technology to stay ahead of evolving security challenges.', 'gradient' => 'from-blue-500 to-sky-600'],
                ];
            @endphp
            @foreach($principles as $i => $p)
                <div class="relative rounded-3xl overflow-hidden bg-gradient-to-br {{ $p['gradient'] }} p-10 text-white" data-animate style="animation-delay: {{ $i * 150 }}ms">
                    <div class="absolute inset-0 line-grid opacity-10"></div>
                    <h3 class="font-display font-bold text-2xl mb-4 relative z-10">{{ $p['title'] }}</h3>
                    <p class="text-blue-100/90 leading-relaxed relative z-10">{{ $p['desc'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="py-20 bg-slate-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <h2 class="text-3xl font-display font-bold text-slate-900 mb-6">Ready to Partner with Us?</h2>
        <p class="text-slate-500 text-lg mb-8">Learn more about our capabilities and how we can support your security objectives.</p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url('/contact') }}" class="btn-primary">Contact Us</a>
            <a href="{{ url('/experience') }}" class="btn-outline">Our Experience</a>
        </div>
    </div>
</section>

@endsection
