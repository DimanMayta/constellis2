{{-- NSG Footer --}}
@php
    $footerDescEn = \App\Models\SiteSetting::get('footer_description_en', 'A network of over 72,000 professionals working to safeguard freedom, democracy, and the rule of law worldwide.');
    $footerDescEs = \App\Models\SiteSetting::get('footer_description_es', 'Una red de más de 72,000 profesionales trabajando para salvaguardar la libertad, la democracia y el estado de derecho en todo el mundo.');
    $companyName = \App\Models\SiteSetting::get('company_name', 'National Security Group');
    $phoneTollFree = \App\Models\SiteSetting::get('phone_toll_free', '+1 866 349 1506');
    $contactEmail = \App\Models\SiteSetting::get('email', 'info@constellis.com');
    $linkedinUrl = \App\Models\SiteSetting::get('linkedin', 'https://www.linkedin.com/company/constellis');
    $twitterUrl = \App\Models\SiteSetting::get('twitter', 'https://twitter.com/constellis');
    $facebookUrl = \App\Models\SiteSetting::get('facebook', 'https://www.facebook.com/constellis');
@endphp
<footer class="relative bg-black text-white overflow-hidden" id="site-footer">
    {{-- Decorative background --}}
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-accent-500/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-blue-600/5 rounded-full blur-[100px]"></div>
    </div>

    {{-- Veterans for Veterans Banner --}}
    <div class="relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 text-center">
            <h3 class="text-3xl md:text-4xl font-display font-bold text-white mb-3">
                <span x-show="$store.lang.current === 'en'">Veterans For <span class="text-accent-400">Veterans</span></span>
                <span x-show="$store.lang.current === 'es'" x-cloak>Veteranos Para <span class="text-accent-400">Veteranos</span></span>
            </h3>
            <p class="text-white/60 text-lg mb-2" x-text="$store.lang.current === 'en' ? 'Military and First Responders are the core of our workforce' : 'El personal militar y rescatistas constituyen el núcleo de nuestra fuerza laboral'"></p>
            <p class="text-white/40 text-sm font-semibold tracking-wider uppercase mb-8" x-text="$store.lang.current === 'en' ? 'Providing the Highest Quality Professionals in the World' : 'Proporcionando los Profesionales de Más Alta Calidad en el Mundo'"></p>
            <div class="max-w-4xl mx-auto">
                <img src="{{ asset('images/NSG.png') }}" alt="Veterans For Veterans" class="mx-auto h-32 md:h-40 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity duration-300">
            </div>

            {{-- Stat --}}
            <p class="text-white/50 text-lg mt-8 max-w-2xl mx-auto"
               x-text="$store.lang.current === 'en'
                   ? '80% of our staff is made up US Veterans. Our executives, directors and management personnel are veterans.'
                   : 'El 80% de nuestro personal está compuesto por veteranos de EE.UU. Nuestros ejecutivos, directores y personal de gestión son veteranos.'">
            </p>
        </div>

        {{-- Our Commitment Block --}}
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-16">
            <div class="grid md:grid-cols-2 gap-0 rounded-2xl overflow-hidden border border-white/10 shadow-2xl shadow-black/30">
                {{-- Left: Text --}}
                <div class="bg-white/[0.04] backdrop-blur-sm p-8 md:p-10 flex flex-col justify-center">
                    <h4 class="text-2xl font-display font-bold text-white mb-5">
                        <span x-show="$store.lang.current === 'en'">Our <span class="text-accent-400">Commitment</span></span>
                        <span x-show="$store.lang.current === 'es'" x-cloak>Nuestro <span class="text-accent-400">Compromiso</span></span>
                    </h4>
                    <p class="text-white/60 text-sm leading-relaxed mb-4"
                       x-text="$store.lang.current === 'en'
                           ? 'We take pride in our heritage and the discipline that military service has instilled in our team. This expertise allows us to provide unparalleled service in logistics and tactical operations.'
                           : 'Nos enorgullecemos de nuestra herencia y la disciplina que el servicio militar ha inculcado en nuestro equipo. Esta experiencia nos permite brindar un servicio sin igual en logística y operaciones tácticas.'">
                    </p>
                    <p class="text-white/50 text-sm leading-relaxed"
                       x-text="$store.lang.current === 'en'
                           ? 'Every member of our leadership understands the unique challenges faced by those who served, ensuring our corporate culture remains mission-focused.'
                           : 'Cada miembro de nuestro liderazgo comprende los desafíos únicos que enfrentan quienes sirvieron, asegurando que nuestra cultura corporativa permanezca enfocada en la misión.'">
                    </p>
                </div>
                {{-- Right: Image Carousel --}}
                <div class="relative h-72 md:h-auto min-h-[320px] bg-slate-900 overflow-hidden"
                     x-data="{
                         current: 0,
                         images: [
                             '{{ asset('images/footer1.png') }}',
                             '{{ asset('images/footer2.png') }}',
                             '{{ asset('images/footer3.jpeg') }}',
                             '{{ asset('images/footer4.jpeg') }}',
                             '{{ asset('images/footer5.jpeg') }}',
                             '{{ asset('images/footer6.jpeg') }}',
                             '{{ asset('images/footer7.jpeg') }}',
                             '{{ asset('images/footer8.jpeg') }}'
                         ],
                         autoplay: null,
                         init() {
                             this.autoplay = setInterval(() => { this.next() }, 4000);
                         },
                         next() { this.current = (this.current + 1) % this.images.length },
                         prev() { this.current = (this.current - 1 + this.images.length) % this.images.length },
                         goto(i) { this.current = i; clearInterval(this.autoplay); this.autoplay = setInterval(() => { this.next() }, 4000); }
                     }">
                    {{-- Images --}}
                    <template x-for="(img, index) in images" :key="index">
                        <img :src="img"
                             alt="Veterans Team"
                             class="absolute inset-0 w-full h-full object-contain transition-opacity duration-700 ease-in-out"
                             :class="current === index ? 'opacity-100' : 'opacity-0'"
                             loading="lazy">
                    </template>

                    {{-- Gradient overlay --}}
                    <div class="absolute inset-0 bg-gradient-to-r from-black/40 via-transparent to-transparent pointer-events-none"></div>

                    {{-- Arrow Controls --}}
                    <button @click="prev(); goto(current)"
                            class="absolute left-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-sm flex items-center justify-center text-white/70 hover:text-white transition-all duration-300 z-10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <button @click="next(); goto(current)"
                            class="absolute right-3 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-black/40 hover:bg-black/70 backdrop-blur-sm flex items-center justify-center text-white/70 hover:text-white transition-all duration-300 z-10">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>

                    {{-- Dots --}}
                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-10">
                        <template x-for="(img, index) in images" :key="'dot-'+index">
                            <button @click="goto(index)"
                                    class="w-2 h-2 rounded-full transition-all duration-300"
                                    :class="current === index ? 'bg-accent-400 w-5' : 'bg-white/40 hover:bg-white/70'">
                            </button>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Projects We Support --}}
    @php
        $supportedProjects = \App\Models\SupportedProject::where('is_active', true)->orderBy('sort_order')->get();
    @endphp
    @if($supportedProjects->count() > 0)
    <div class="relative border-b border-white/10" id="projects-we-support">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            {{-- Header --}}
            <div class="text-center mb-12">
                <h3 class="text-3xl md:text-4xl font-display font-bold text-white mb-4">
                    <span x-show="$store.lang.current === 'en'">Projects We <span class="text-accent-400">Support</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Proyectos Que <span class="text-accent-400">Apoyamos</span></span>
                </h3>
                <div class="w-16 h-0.5 bg-accent-500 mx-auto mb-6"></div>
                <p class="text-white/50 text-base max-w-2xl mx-auto leading-relaxed"
                   x-text="$store.lang.current === 'en'
                       ? 'The executive board has approved the following Non-Profit Organizations to receive 1% of our net income as a donation for their work. Please help us on supporting these great organizations by donating:'
                       : 'La junta directiva ha aprobado que las siguientes organizaciones sin fines de lucro reciban el 1% de nuestros ingresos netos como donación por su labor. Por favor, ayúdenos a apoyar a estas grandes organizaciones donando:'">
                </p>
            </div>

            {{-- Projects Grid --}}
            <div class="grid sm:grid-cols-2 lg:grid-cols-{{ min($supportedProjects->count(), 4) }} gap-6">
                @foreach($supportedProjects as $project)
                    <div class="group relative bg-white/[0.04] hover:bg-white/[0.08] rounded-2xl border border-white/[0.08] hover:border-accent-500/30 transition-all duration-500 hover:-translate-y-1 overflow-hidden backdrop-blur-sm">
                        {{-- Top accent line --}}
                        <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-accent-500 via-red-400 to-accent-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

                        {{-- Logo Area --}}
                        <div class="relative h-40 overflow-hidden">
                            @if($project->logo)
                                <img src="{{ asset('storage/' . $project->logo) }}"
                                     alt="{{ $project->name_en }}"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @elseif($project->image_url)
                                <img src="{{ $project->image_url }}"
                                     alt="{{ $project->name_en }}"
                                     class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            @else
                                <div class="w-full h-full bg-white/[0.03] flex items-center justify-center">
                                    <div class="w-14 h-14 rounded-2xl bg-accent-500/10 flex items-center justify-center text-accent-400 group-hover:bg-accent-500 group-hover:text-white transition-all duration-300">
                                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Content --}}
                        <div class="p-5">
                            <h4 class="font-display font-bold text-base text-white mb-2 group-hover:text-accent-400 transition-colors duration-300"
                                x-text="$store.lang.current === 'en' ? '{{ addslashes($project->name_en) }}' : '{{ addslashes($project->name_es) }}'">
                            </h4>
                            <p class="text-white/40 text-sm leading-relaxed mb-4 line-clamp-3"
                               x-text="$store.lang.current === 'en' ? '{{ addslashes($project->description_en) }}' : '{{ addslashes($project->description_es) }}'">
                            </p>

                            @if($project->website_url)
                                <a href="{{ $project->website_url }}" target="_blank" rel="noopener"
                                   class="inline-flex items-center gap-2 text-accent-400 hover:text-accent-300 font-bold text-sm group/link transition-colors duration-300">
                                    <span x-text="$store.lang.current === 'en' ? 'SUPPORT PROJECT' : 'APOYAR PROYECTO'"></span>
                                    <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                                    </svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>


        </div>
    </div>
    @endif

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Main Footer --}}
        <div class="py-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12">
            {{-- Brand --}}
            <div class="lg:col-span-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6">
                    <img src="{{ asset('images/NSG.png') }}"
                         alt="{{ $companyName }}"
                         class="h-14 w-auto drop-shadow-lg">
                </a>
                <p class="text-white/40 text-sm leading-relaxed mb-8 max-w-sm">
                    <span x-show="$store.lang.current === 'en'">{{ $footerDescEn }}</span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>{{ $footerDescEs }}</span>
                </p>
                <div class="flex items-center gap-3">
                    @foreach([
                        ['LinkedIn', $linkedinUrl, 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z'],
                        ['X', $twitterUrl, 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
                        ['Facebook', $facebookUrl, 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                    ] as $social)
                        <a href="{{ $social[1] }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-white/40 hover:text-white hover:bg-accent-500 hover:border-accent-500 transition-all duration-300" aria-label="{{ $social[0] }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $social[2] }}"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Links (NOT dynamic — kept as-is per user request) --}}
            @php
                $footerSections = [
                    ['title' => 'Navigation', 'links' => [
                        ['Home', '/'],
                        ['About Us', '/#about'],
                        ['Services', '/#services'],
                        ['Opportunities', '/careers'],
                        ['Relevant Events', '/#events'],
                    ]],
                    ['title' => 'Operations', 'links' => array_filter([
                        ['Testimonials', '/#testimonials'],
                        ['Clients', '/#clients'],
                        \App\Models\SiteSetting::get('store_enabled', 'true') === 'true' ? ['Employee Store', '/store/login'] : null,
                        ['Intranet', '/login?redirect=/intranet'],
                    ])],
                    ['title' => 'Legal', 'links' => [
                        ['Contact Us', '/contact'],
                        ['Privacy Policy', '/privacy-policy'],
                        ['Terms of Use', '/terms-of-use'],
                    ]],
                ];
            @endphp

            @foreach($footerSections as $section)
                <div class="lg:col-span-2">
                    <h4 class="font-display font-bold text-sm uppercase tracking-wider text-white mb-6">{{ $section['title'] }}</h4>
                    <ul class="space-y-3">
                        @foreach($section['links'] as $link)
                            <li>
                                <a href="{{ str_starts_with($link[1], 'http') ? $link[1] : url($link[1]) }}"
                                   @if(str_starts_with($link[1], 'http')) target="_blank" rel="noopener" @endif
                                   class="text-white/40 hover:text-accent-400 text-sm transition-colors duration-200 font-medium">
                                    {{ $link[0] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            {{-- Contact --}}
            <div class="lg:col-span-2">
                <h4 class="font-display font-bold text-sm uppercase tracking-wider text-white mb-6">
                    <span x-show="$store.lang.current === 'en'">Contact</span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Contacto</span>
                </h4>
                <ul class="space-y-4">
                    <li>
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phoneTollFree) }}" class="flex items-center gap-3 text-white/40 hover:text-accent-400 transition-colors text-sm">
                            <svg class="w-4 h-4 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $phoneTollFree }}
                        </a>
                    </li>
                    <li>
                        <a href="mailto:{{ $contactEmail }}" class="flex items-center gap-3 text-white/40 hover:text-accent-400 transition-colors text-sm">
                            <svg class="w-4 h-4 text-accent-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            {{ $contactEmail }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/10 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-white/30 text-xs">&copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.</p>
            <div class="flex items-center gap-6 text-xs text-white/30">
                <a href="{{ url('/privacy-policy') }}" class="hover:text-accent-400 transition-colors">Privacy Policy</a>
                <a href="{{ url('/terms-of-use') }}" class="hover:text-accent-400 transition-colors">Terms of Use</a>
            </div>
        </div>
    </div>
</footer>
