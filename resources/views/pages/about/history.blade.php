@extends('layouts.app')
@section('title', 'Constellis History — Our Legacy')
@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Who We Are</span>
        <h1 class="section-heading-white mb-6">Constellis History</h1>
        <p class="section-subheading-white">Two decades of excellence in global security and risk management.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="relative">
            <div class="absolute left-8 top-0 bottom-0 w-px bg-gradient-to-b from-blue-400 via-blue-200 to-transparent"></div>
            @php $timeline = [
                ['year' => '2014', 'title' => 'Constellis Founded', 'desc' => 'Constellis was formed through the strategic merger of several leading security companies.'],
                ['year' => '2016', 'title' => 'Global Expansion', 'desc' => 'Expanded operations to over 30 countries with regional headquarters worldwide.'],
                ['year' => '2018', 'title' => 'Technology Integration', 'desc' => 'Launched advanced technology services with UAS, sensors, and API solutions.'],
                ['year' => '2020', 'title' => 'Humanitarian Operations', 'desc' => 'Expanded humanitarian demining and environmental remediation operations.'],
                ['year' => '2022', 'title' => 'Training Excellence', 'desc' => 'Opened state-of-the-art training facilities for advanced security programs.'],
                ['year' => '2024', 'title' => 'LEXSO™ Launch', 'desc' => 'Launched the LEXSO™ platform for law enforcement modernization.'],
                ['year' => '2026', 'title' => 'Next Chapter', 'desc' => 'Continuing to innovate comprehensive security solutions worldwide.'],
            ]; @endphp
            @foreach($timeline as $i => $item)
                <div class="relative flex items-start gap-8 mb-12" data-animate style="animation-delay: {{ $i * 150 }}ms">
                    <div class="relative z-10 w-16 h-16 rounded-2xl bg-blue-50 border border-blue-200 flex items-center justify-center shrink-0">
                        <span class="text-blue-600 font-display font-bold text-sm">{{ $item['year'] }}</span>
                    </div>
                    <div class="card p-6 flex-1">
                        <h3 class="text-slate-900 font-display font-semibold text-lg mb-2">{{ $item['title'] }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $item['desc'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
