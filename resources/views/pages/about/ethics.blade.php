@extends('layouts.app')
@section('title', 'Ethics, Policies & Certifications — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Who We Are</span>
        <h1 class="section-heading-white mb-6">Ethics & Certifications</h1>
        <p class="section-subheading-white">Our commitment to the highest ethical standards and internationally recognized certifications.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($certifications ?? [] as $i => $cert)
                <div class="card p-8" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-6">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    </div>
                    <h3 class="text-slate-900 font-display font-semibold text-lg mb-3">{{ $cert->name }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed">{{ $cert->description }}</p>
                </div>
            @empty
                @foreach(['ISO 9001:2015' => 'Quality Management System certification ensuring consistent, high-quality service delivery.', 'ISO 14001:2015' => 'Environmental Management System demonstrating commitment to environmental responsibility.', 'ISO 45001:2018' => 'Occupational Health & Safety Management ensuring worker safety and well-being.', 'ANAB Accredited' => 'ANSI National Accreditation Board recognition for conformity assessment.', 'PSC.1 Certified' => 'Private Security Company Operations certified under international standards.', 'ICoCA Member' => 'International Code of Conduct Association membership for responsible security.'] as $name => $desc)
                    <div class="card p-8" data-animate>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 mb-6">
                            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <h3 class="text-slate-900 font-display font-semibold text-lg mb-3">{{ $name }}</h3>
                        <p class="text-slate-400 text-sm leading-relaxed">{{ $desc }}</p>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>
@endsection
