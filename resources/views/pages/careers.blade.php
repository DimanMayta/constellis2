@extends('layouts.app')
@section('title')
    <template x-if="$store.lang.current === 'en'">Careers — Constellis</template>
    <template x-if="$store.lang.current === 'es'">Carreras — Constellis</template>
@endsection
@section('content')
<section class="relative py-28 overflow-hidden bg-gradient-to-br from-[#1d345d] via-[#253d6a] to-[#1d345d]">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-[#9298af]/10 top-0 right-0 animate-morph"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-[#9298af] text-sm font-bold tracking-wider uppercase mb-4 block"
              x-text="$store.lang.current === 'en' ? 'Join Our Team' : 'Únete a Nuestro Equipo'"></span>
        <h1 class="section-heading-white mb-6"
            x-text="$store.lang.current === 'en' ? 'Build Your Career' : 'Construye Tu Carrera'"></h1>
        <p class="section-subheading-white mb-10"
           x-text="$store.lang.current === 'en' ? 'Join over 20,000 professionals worldwide in a mission-driven organization dedicated to security excellence.' : 'Únete a más de 20,000 profesionales en todo el mundo en una organización orientada a la misión dedicada a la excelencia en seguridad.'"></p>
        <a href="https://myjobs.adp.com/constelliscareers/" target="_blank" rel="noopener" class="btn-white">
            <span x-text="$store.lang.current === 'en' ? 'Search Open Positions' : 'Buscar Posiciones Abiertas'"></span>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="#eff6ef"/></svg></div>
</section>

<section class="py-20 bg-[#eff6ef]">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <h2 class="text-3xl md:text-4xl font-display font-bold text-[#1d345d] mb-4">
                <span x-text="$store.lang.current === 'en' ? 'Why' : '¿Por qué'"></span>
                <span class="text-[#e7333e]">Constellis</span><span x-text="$store.lang.current === 'en' ? '?' : '?'"></span>
            </h2>
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

<section class="py-20 bg-gradient-to-br from-[#1d345d] via-[#253d6a] to-[#1d345d]">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center" data-animate>
        <h2 class="text-3xl font-display font-bold text-white mb-6"
            x-text="$store.lang.current === 'en' ? 'Ready to Make an Impact?' : '¿Listo para Generar un Impacto?'"></h2>
        <p class="text-[#9298af] text-lg mb-8"
           x-text="$store.lang.current === 'en' ? 'Explore our current openings and take the first step toward a rewarding career.' : 'Explora nuestras oportunidades actuales y da el primer paso hacia una carrera gratificante.'"></p>
        <a href="https://myjobs.adp.com/constelliscareers/" target="_blank" rel="noopener" class="inline-flex items-center gap-2 bg-[#e7333e] hover:bg-[#d42d37] text-white font-semibold px-10 py-4 rounded-xl transition-all duration-300 shadow-lg shadow-[#e7333e]/25 hover:shadow-xl hover:shadow-[#e7333e]/30">
            <span x-text="$store.lang.current === 'en' ? 'View All Open Positions' : 'Ver Todas las Posiciones Abiertas'"></span>
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
        </a>
    </div>
</section>
@endsection
