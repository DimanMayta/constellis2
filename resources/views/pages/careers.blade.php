@extends('layouts.app')
@section('title')
    <template x-if="$store.lang.current === 'en'">Careers — Constellis</template>
    <template x-if="$store.lang.current === 'es'">Carreras — Constellis</template>
@endsection
@section('content')

{{-- ============================================================
HERO — Careers with Background Image Watermark
============================================================ --}}
<section class="relative min-h-[520px] flex items-center overflow-hidden">
    {{-- Background image — subtle watermark --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/careers.webp') }}" alt=""
             class="absolute inset-0 w-full h-full object-cover object-center"
             loading="eager">
        {{-- Heavy overlay for watermark effect --}}
        <div class="absolute inset-0 bg-gradient-to-r from-[#0f1f3d]/95 via-[#1d345d]/90 to-[#1d345d]/85"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-[#1d345d]/40 via-transparent to-[#1d345d]/60"></div>
    </div>

    {{-- Subtle grid pattern --}}
    <div class="absolute inset-0 line-grid opacity-[0.06]"></div>

    {{-- Decorative accents --}}
    <div class="absolute top-20 right-[15%] w-72 h-72 bg-[#e7333e]/8 rounded-full blur-[100px]"></div>
    <div class="absolute bottom-10 left-[10%] w-60 h-60 bg-[#9298af]/10 rounded-full blur-[80px]"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-28 w-full">
        <div class="max-w-2xl">
            {{-- Eyebrow --}}
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-[2px] bg-[#e7333e]"></div>
                <span class="text-[#e7333e] text-xs font-bold tracking-[0.2em] uppercase"
                      x-text="$store.lang.current === 'en' ? 'Join Our Team' : 'Únete a Nuestro Equipo'"></span>
            </div>

            {{-- Title --}}
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-display font-bold text-white leading-[1.1] mb-6">
                <span x-show="$store.lang.current === 'en'">Build Your <span class="text-[#e7333e]">Career</span></span>
                <span x-show="$store.lang.current === 'es'" x-cloak>Construye Tu <span class="text-[#e7333e]">Carrera</span></span>
            </h1>

            {{-- Description --}}
            <p class="text-white/60 text-lg leading-relaxed mb-10 max-w-xl"
               x-text="$store.lang.current === 'en' ? 'Join over 20,000 professionals worldwide in a mission-driven organization dedicated to security excellence.' : 'Únete a más de 20,000 profesionales en todo el mundo en una organización orientada a la misión dedicada a la excelencia en seguridad.'"></p>

            {{-- CTA Buttons --}}
            <div class="flex flex-wrap gap-4">
                <a href="https://myjobs.adp.com/constelliscareers/" target="_blank" rel="noopener"
                   class="inline-flex items-center gap-2 bg-[#e7333e] hover:bg-[#d42d37] text-white font-semibold px-8 py-4 rounded-xl transition-all duration-300 shadow-lg shadow-[#e7333e]/25 hover:shadow-xl hover:shadow-[#e7333e]/30 hover:-translate-y-0.5">
                    <span x-text="$store.lang.current === 'en' ? 'Search Open Positions' : 'Buscar Posiciones Abiertas'"></span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </a>
                <a href="#why-constellis"
                   class="inline-flex items-center gap-2 bg-white/10 hover:bg-white/15 text-white font-semibold px-8 py-4 rounded-xl border border-white/15 hover:border-white/25 transition-all duration-300 backdrop-blur-sm">
                    <span x-text="$store.lang.current === 'en' ? 'Learn More' : 'Conoce Más'"></span>
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </a>
            </div>
        </div>

        {{-- Stats row --}}
        <div class="mt-16 pt-10 border-t border-white/[0.08]">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12">
                @php $stats = [
                    ['num' => '20,000+', 'label_en' => 'Professionals', 'label_es' => 'Profesionales'],
                    ['num' => '35+', 'label_en' => 'Countries', 'label_es' => 'Países'],
                    ['num' => '24/7', 'label_en' => 'Operations', 'label_es' => 'Operaciones'],
                    ['num' => '100%', 'label_en' => 'Mission Focus', 'label_es' => 'Enfoque en la Misión'],
                ]; @endphp
                @foreach($stats as $stat)
                    <div class="text-center md:text-left">
                        <p class="text-2xl md:text-3xl font-display font-bold text-white mb-1">{{ $stat['num'] }}</p>
                        <p class="text-white/40 text-sm font-medium"
                           x-text="$store.lang.current === 'en' ? '{{ $stat['label_en'] }}' : '{{ $stat['label_es'] }}'"></p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0 z-10"><svg viewBox="0 0 1440 60" fill="none" class="w-full"><path d="M0,60 L0,30 Q360,0 720,30 Q1080,60 1440,20 L1440,60 Z" fill="#eff6ef"/></svg></div>
</section>

{{-- ============================================================
WHY CONSTELLIS — Benefits Grid
============================================================ --}}
<section class="py-20 bg-[#eff6ef]" id="why-constellis">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <h2 class="text-3xl md:text-4xl font-display font-bold text-[#1d345d] mb-4">
                <span x-text="$store.lang.current === 'en' ? 'Why' : '¿Por qué'"></span>
                <span class="text-[#e7333e]">Constellis</span><span x-text="$store.lang.current === 'en' ? '?' : '?'"></span>
            </h2>
            <div class="w-16 h-[2px] bg-[#e7333e] mx-auto mt-4 mb-5"></div>
            <p class="text-[#9298af] text-lg max-w-2xl mx-auto"
               x-text="$store.lang.current === 'en' ? 'We offer competitive benefits and a supportive work environment.' : 'Ofrecemos beneficios competitivos y un entorno laboral de apoyo.'"></p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @php $benefits = [
                ['icon' => 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                 'title_en' => 'Health & Wellness', 'title_es' => 'Salud y Bienestar',
                 'desc_en' => 'Comprehensive medical, dental, and vision coverage.', 'desc_es' => 'Cobertura médica, dental y de visión integral.'],
                ['icon' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                 'title_en' => 'Compensation', 'title_es' => 'Compensación',
                 'desc_en' => 'Market-leading salaries with performance bonuses.', 'desc_es' => 'Salarios líderes en el mercado con bonos por desempeño.'],
                ['icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253',
                 'title_en' => 'Development', 'title_es' => 'Desarrollo',
                 'desc_en' => 'Training programs and career advancement.', 'desc_es' => 'Programas de capacitación y crecimiento profesional.'],
                ['icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                 'title_en' => 'Global', 'title_es' => 'Global',
                 'desc_en' => 'Work in over 35 countries worldwide.', 'desc_es' => 'Trabaja en más de 35 países alrededor del mundo.'],
                ['icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z',
                 'title_en' => 'Veterans', 'title_es' => 'Veteranos',
                 'desc_en' => 'Proud employer with veteran support programs.', 'desc_es' => 'Empleador orgulloso con programas de apoyo a veteranos.'],
                ['icon' => 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z',
                 'title_en' => 'Culture', 'title_es' => 'Cultura',
                 'desc_en' => 'Built on integrity, respect, and excellence.', 'desc_es' => 'Basada en integridad, respeto y excelencia.'],
            ]; @endphp
            @foreach($benefits as $i => $b)
                <div class="bg-white rounded-2xl p-8 border border-[#9298af]/20 shadow-sm hover:shadow-lg hover:border-[#e7333e]/30 transition-all duration-300 group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="w-12 h-12 rounded-xl bg-[#1d345d]/10 border border-[#1d345d]/20 flex items-center justify-center text-[#1d345d] mb-5 group-hover:bg-[#e7333e] group-hover:text-white group-hover:border-[#e7333e] transition-all duration-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $b['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-[#1d345d] font-display font-semibold text-lg mb-3"
                        x-text="$store.lang.current === 'en' ? '{{ $b['title_en'] }}' : '{{ $b['title_es'] }}'"></h3>
                    <p class="text-[#9298af] text-sm leading-relaxed"
                       x-text="$store.lang.current === 'en' ? '{{ $b['desc_en'] }}' : '{{ $b['desc_es'] }}'"></p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
CTA — Bottom Section with Background Image Watermark
============================================================ --}}
<section class="relative py-24 overflow-hidden">
    {{-- Background image watermark --}}
    <div class="absolute inset-0">
        <img src="{{ asset('images/careers.webp') }}" alt=""
             class="absolute inset-0 w-full h-full object-cover"
             loading="lazy">
        <div class="absolute inset-0 bg-gradient-to-r from-[#1d345d]/95 via-[#1d345d]/92 to-[#1d345d]/88"></div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10" data-animate>
        <h2 class="text-3xl md:text-4xl font-display font-bold text-white mb-6"
            x-text="$store.lang.current === 'en' ? 'Ready to Make an Impact?' : '¿Listo para Generar un Impacto?'"></h2>
        <p class="text-white/50 text-lg mb-10 max-w-2xl mx-auto"
           x-text="$store.lang.current === 'en' ? 'Explore our current openings and take the first step toward a rewarding career.' : 'Explora nuestras oportunidades actuales y da el primer paso hacia una carrera gratificante.'"></p>
        <a href="https://myjobs.adp.com/constelliscareers/" target="_blank" rel="noopener"
           class="inline-flex items-center gap-2 bg-[#e7333e] hover:bg-[#d42d37] text-white font-semibold px-10 py-4 rounded-xl transition-all duration-300 shadow-lg shadow-[#e7333e]/25 hover:shadow-xl hover:shadow-[#e7333e]/30 hover:-translate-y-0.5">
            <span x-text="$store.lang.current === 'en' ? 'View All Open Positions' : 'Ver Todas las Posiciones Abiertas'"></span>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>
</section>
@endsection
