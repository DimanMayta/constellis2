@extends('layouts.app')

@section('title', 'NSG — Global Security & Defense Solutions')
@section('meta_description', 'A network of over 72,000 professionals working to safeguard freedom, democracy, and the rule of law worldwide.')

@section('content')

    {{-- ============================================================
    HERO SLIDER — Full-width, dynamic slides, sequential, drag/swipe
    ============================================================ --}}
    <section class="relative" id="hero" x-data="heroSlider()" x-init="startAutoPlay()">
        <div class="relative w-full h-screen min-h-[600px] overflow-hidden" @mouseenter="pauseAutoPlay()"
            @mouseleave="startAutoPlay()">

            {{-- Slides --}}
            @php
                $carouselBgs = [
                    ['url' => asset('images/2 carrusel-special forces.jpg.jpeg'), 'pos' => 'left top', 'mobilePos' => '80% center', 'size' => 'cover'],       // Slide 1: "Freedom Through Strength"
                    ['url' => asset('images/carrucel12.jpeg'), 'pos' => 'center 20%', 'mobilePos' => 'center center', 'size' => 'cover'],                         // Slide 2: "World-Class Training"
                    ['url' => asset('images/carrucel14.jpeg'), 'pos' => 'center 15%', 'mobilePos' => 'center top', 'size' => 'cover'],                             // Slide 3: "Veterans For Veterans"
                    ['url' => asset('images/carrucel11.jpeg'), 'pos' => 'center 15%', 'mobilePos' => 'center center', 'size' => 'cover'],                          // Slide 4: "Protecting Nations"
                    ['url' => asset('images/3carrusel-shaking hands.jpg.jpeg'), 'pos' => 'top', 'mobilePos' => 'center center', 'size' => 'cover'],               // Slide 5: "Career Opportunities"
                    ['url' => asset('images/carrucel13.avif'), 'pos' => 'center 15%', 'mobilePos' => 'center center', 'size' => 'cover'],                          // Slide 6: "Justice & Rule of Law"
                    ['url' => asset('images/5carrusel-help.jpg.jpeg'), 'pos' => 'top', 'mobilePos' => 'center center', 'size' => 'cover'],                         // Slide 7: "Building Global Partnerships"
                    ['url' => asset('images/4carrusel-ayuda medica2.jpg.jpeg'), 'pos' => 'top', 'mobilePos' => '50% 30%', 'size' => 'cover'],                // Slide 8: "Rapid Response"
                ];
            @endphp
            @foreach($heroSlides as $i => $slide)
                @php
                    $bg = $carouselBgs[$i % count($carouselBgs)];
                    $pos = $slide->bg_position ? 'center ' . $slide->bg_position . '%' : $bg['pos'];
                    $mobilePos = $bg['mobilePos'];
                    $imgEn = $slide->bg_image ? asset('storage/' . $slide->bg_image) : $bg['url'];
                    $imgEs = $slide->bg_image_es ? asset('storage/' . $slide->bg_image_es) : null;
                @endphp
                <style>
                    .hero-slide-bg-{{ $i }} {
                        background-image: url('{{ $imgEn }}');
                        background-position:
                            {{ $pos }}
                        ;
                        background-size: cover;
                        background-repeat: no-repeat;
                    }

                    @media (max-width: 768px) {
                        .hero-slide-bg-{{ $i }} {
                            background-position:
                                {{ $mobilePos }}
                            ;
                        }
                    }
                </style>
                <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                    :class="currentSlide === {{ $i }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                    {{-- English background (or default if no Spanish version) --}}
                    <div class="absolute inset-0 hero-slide-bg-{{ $i }}" @if($imgEs) x-show="$store.lang.current === 'en'"
                    x-transition.opacity.duration.500ms @endif>
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/20 max-md:bg-gradient-to-t max-md:from-black/90 max-md:via-black/60 max-md:to-black/30">
                        </div>
                    </div>
                    @if($imgEs)
                        {{-- Spanish background --}}
                        <div class="absolute inset-0" x-show="$store.lang.current === 'es'" x-transition.opacity.duration.500ms
                            x-cloak
                            style="background-image: url('{{ $imgEs }}'); background-position: {{ $mobilePos }}; background-size: cover; background-repeat: no-repeat;">
                            <div class="absolute inset-0 bg-gradient-to-r from-black/80 via-black/50 to-black/20"></div>
                        </div>
                    @endif
                    <div class="relative z-10 flex items-center h-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
                        <div class="max-w-2xl">
                            <span
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-accent-500/20 border border-accent-500/30 text-accent-400 text-xs font-bold tracking-wider uppercase mb-6">
                                <span class="w-2 h-2 rounded-full bg-accent-500 animate-pulse"></span>
                                <span
                                    x-text="$store.lang.current === 'en' ? '{{ addslashes($slide->badge_en) }}' : '{{ addslashes($slide->badge_es) }}'"></span>
                            </span>
                            <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold text-white leading-[1.08] mb-6">
                                <span
                                    x-text="$store.lang.current === 'en' ? '{{ addslashes($slide->title_a_en) }}' : '{{ addslashes($slide->title_a_es) }}'"></span><br>
                                <span class="text-accent-400"
                                    x-text="$store.lang.current === 'en' ? '{{ addslashes($slide->title_b_en) }}' : '{{ addslashes($slide->title_b_es) }}'"></span>
                            </h1>
                            <p class="text-xl text-white/80 leading-relaxed mb-8 max-w-lg"
                                x-text="$store.lang.current === 'en' ? '{{ addslashes($slide->description_en) }}' : '{{ addslashes($slide->description_es) }}'">
                            </p>
                            @php
                                $ctaSection = ltrim($slide->cta_link, '#');
                            @endphp
                            <a href="{{ $slide->cta_link }}"
                                @click.prevent="$store.sections.show('{{ $ctaSection }}'); $nextTick(() => { document.getElementById('{{ $ctaSection }}')?.scrollIntoView({ behavior: 'smooth', block: 'start' }) })"
                                class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-sm bg-accent-500 text-white hover:bg-accent-600 shadow-lg shadow-accent-500/25 transition-all duration-300 hover:-translate-y-0.5">
                                <span
                                    x-text="$store.lang.current === 'en' ? '{{ addslashes($slide->cta_en) }}' : '{{ addslashes($slide->cta_es) }}'"></span>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Dots --}}
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2">
                @foreach($heroSlides as $i => $slide)
                    <button @click="goTo({{ $i }})" class="w-2.5 h-2.5 rounded-full transition-all duration-300"
                        :class="currentSlide === {{ $i }} ? 'bg-white w-8 rounded-full' : 'bg-white/40 hover:bg-white/60'">
                    </button>
                @endforeach
            </div>

            {{-- Arrows --}}
            <button @click="prev()"
                class="absolute left-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
            </button>
            <button @click="next()"
                class="absolute right-6 top-1/2 -translate-y-1/2 z-20 w-12 h-12 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </button>
        </div>
    </section>

    @push('scripts')
        <script>
            function heroSlider() {
                return {
                    currentSlide: 0,
                    totalSlides: {{ $heroSlides->count() }},
                    interval: null,
                    startAutoPlay() {
                        this.stopAutoPlay();
                        this.interval = setInterval(() => {
                            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                        }, 10000);
                    },
                    pauseAutoPlay() { clearInterval(this.interval); },
                    stopAutoPlay() { clearInterval(this.interval); },
                    next() { this.stopAutoPlay(); this.currentSlide = (this.currentSlide + 1) % this.totalSlides; this.startAutoPlay(); },
                    prev() { this.stopAutoPlay(); this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides; this.startAutoPlay(); },
                    goTo(i) { this.stopAutoPlay(); this.currentSlide = i; this.startAutoPlay(); },
                }
            }
        </script>
    @endpush


    {{-- ============================================================
    ABOUT US - Light Theme
    ============================================================ --}}
    <section class="relative py-24 bg-white overflow-hidden" id="about">
        {{-- Background effects --}}
        <div class="absolute top-0 left-1/3 w-[500px] h-[500px] bg-accent-500/5 rounded-full blur-[150px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-blue-500/5 rounded-full blur-[120px]"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            <div class="text-center mb-16" data-animate>
                <span class="text-accent-500 text-sm font-bold tracking-wider uppercase mb-4 block"
                    x-text="$store.lang.current === 'en' ? 'About Us' : 'Sobre Nosotros'"></span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-slate-900 leading-tight">
                    <span x-show="$store.lang.current === 'en'">Who We <span class="text-accent-500">Are</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Quiénes <span
                            class="text-accent-500">Somos</span></span>
                </h2>
                <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-accent-500 to-transparent mx-auto mt-6"></div>
            </div>

            <div x-data="{ activeTab: 'who' }" @set-about-tab.window="activeTab = $event.detail.tab"
                class="max-w-5xl mx-auto">
                {{-- Tab Headers --}}
                <div class="flex flex-wrap justify-center gap-2 mb-12">
                    <button @click="activeTab = 'who'"
                        :class="activeTab === 'who' ? 'bg-accent-500 text-white shadow-lg shadow-accent-500/25' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-800 border border-slate-200'"
                        class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        <span x-text="$store.lang.current === 'en' ? 'Who We Are' : 'Quiénes Somos'"></span>
                    </button>
                    <button @click="activeTab = 'vision'"
                        :class="activeTab === 'vision' ? 'bg-accent-500 text-white shadow-lg shadow-accent-500/25' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-800 border border-slate-200'"
                        class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        <span x-text="$store.lang.current === 'en' ? 'Vision' : 'Visión'"></span>
                    </button>
                    <button @click="activeTab = 'mission'"
                        :class="activeTab === 'mission' ? 'bg-accent-500 text-white shadow-lg shadow-accent-500/25' : 'bg-slate-100 text-slate-600 hover:bg-slate-200 hover:text-slate-800 border border-slate-200'"
                        class="px-6 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                        <span x-text="$store.lang.current === 'en' ? 'Mission' : 'Misión'"></span>
                    </button>
                </div>

                {{-- WHO WE ARE --}}
                <div x-show="activeTab === 'who'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                    <div class="bg-slate-50 rounded-3xl p-8 md:p-12 border border-slate-200 shadow-xl">
                        <template x-if="$store.lang.current === 'en'">
                            <div>
                                <p class="text-slate-800 text-lg leading-relaxed mb-6">We are a network of over <strong
                                        class="text-accent-500 font-bold">72,000 people</strong> working together to assist
                                    in the
                                    assessment, planification, organization and development of freedom, democracy, rule of
                                    law, national order, national defense, new international allies and the development of
                                    third world countries and/or developed nations that are undergoing political duress and
                                    instability.</p>
                                <p class="text-slate-600 leading-relaxed mb-8">Our organization alongside our network of
                                    partner companies has a proven and successful record helping various Host Nations. We do
                                    this through extremely experienced individuals ranging in various fields such as former
                                    dignitaries, diplomats, senators, house representatives, federal agents, law enforcement
                                    professionals, university professors, Supreme Court judges, vast range of experts in the
                                    field of international law, medical experts, national defense experts, intelligence
                                    agencies experts, engineers and soldiers.</p>
                                {{-- Inline Image Carousel --}}
                                @php
                                    $whoSection = $aboutSections->firstWhere('tab_key', 'who');
                                    $whoCarousel = $whoSection && $whoSection->carousel_images ? $whoSection->carousel_images : [];
                                    if (empty($whoCarousel)) {
                                        $whoCarousel = ['images/About Us.png', 'images/sobre1.jpeg', 'images/sobre2.png', 'images/sobre3.png', 'images/sobre4.png', 'images/sobre5.png', 'images/sobre6.png', 'images/about us5.png', 'images/about us2.png', 'images/about us3.png', 'images/about us4.png', 'images/us1.jpeg', 'images/us2.jpeg', 'images/us3.jpeg'];
                                        $whoFromStorage = false;
                                    } else {
                                        $whoFromStorage = true;
                                    }
                                    $whoCount = count($whoCarousel);
                                @endphp
                                <div class="my-8 rounded-2xl overflow-hidden shadow-xl border border-slate-200 relative aspect-video bg-slate-100"
                                    x-data="{ whoSlide: 0, whoTotal: {{ $whoCount }}, whoInt: null,
                                                                 initWho() { this.whoInt = setInterval(() => { this.whoSlide = (this.whoSlide + 1) % this.whoTotal; }, 4000); },
                                                                 stopWho() { clearInterval(this.whoInt); },
                                                                 startWho() { this.stopWho(); this.whoInt = setInterval(() => { this.whoSlide = (this.whoSlide + 1) % this.whoTotal; }, 4000); }
                                                             }" x-init="initWho()" @mouseenter="stopWho()"
                                    @mouseleave="startWho()">
                                    @foreach($whoCarousel as $wi => $wImg)
                                        <img src="{{ $whoFromStorage ? asset('storage/' . $wImg) : asset($wImg) }}"
                                            alt="About NSG {{ $wi + 1 }}"
                                            class="absolute inset-0 w-full h-full object-contain transition-opacity duration-1000 ease-in-out rounded-2xl"
                                            :class="whoSlide === {{ $wi }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                    @endforeach
                                    {{-- Arrows --}}
                                    <button @click="stopWho(); whoSlide = (whoSlide - 1 + whoTotal) % whoTotal; startWho()"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button @click="stopWho(); whoSlide = (whoSlide + 1) % whoTotal; startWho()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    {{-- Dots --}}
                                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5">
                                        @for($wd = 0; $wd < $whoCount; $wd++)
                                            <button @click="stopWho(); whoSlide = {{ $wd }}; startWho()"
                                                class="w-2 h-2 rounded-full transition-all duration-300"
                                                :class="whoSlide === {{ $wd }} ? 'bg-white w-5 rounded-full' : 'bg-white/40 hover:bg-white/60'"></button>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-slate-600 leading-relaxed">In order to bring the very best in expertise and
                                    support to our given tasks we contract some of the world's most prestigious
                                    organizations to work alongside the local residents of Host Nations. We all work
                                    together to bring freedom, democracy, rule of law, order and development to the
                                    Oppressed people throughout the world, thus providing new opportunities in the
                                    development of Host Nations.</p>
                            </div>
                        </template>
                        <template x-if="$store.lang.current === 'es'">
                            <div>
                                <p class="text-slate-800 text-lg leading-relaxed mb-6">Somos una red de más de <strong
                                        class="text-accent-500 font-bold">72,000 personas</strong> que trabajan de manera
                                    conjunta
                                    para asistir en la evaluación, planificación, organización y desarrollo de la libertad,
                                    la democracia, el estado de derecho, el orden nacional, la defensa nacional, la
                                    generación de nuevas alianzas internacionales y el desarrollo de países del tercer mundo
                                    y/o naciones desarrolladas que atraviesan situaciones de presión política e
                                    inestabilidad.</p>
                                <p class="text-slate-600 leading-relaxed mb-8">Nuestra organización, junto con nuestra red
                                    de empresas asociadas, cuenta con un historial comprobado de éxito ayudando a diversos
                                    países anfitriones. Esto lo logramos a través de profesionales altamente experimentados
                                    en múltiples campos, tales como ex dignatarios, diplomáticos, senadores, representantes
                                    legislativos, agentes federales, profesionales de las fuerzas del orden, profesores
                                    universitarios, jueces de tribunales supremos, expertos en derecho internacional,
                                    especialistas médicos, expertos en defensa nacional, especialistas en agencias de
                                    inteligencia, ingenieros y personal militar.</p>
                                {{-- Inline Image Carousel (same as EN) --}}
                                <div class="my-8 rounded-2xl overflow-hidden shadow-xl border border-slate-200 relative aspect-video bg-slate-100"
                                    x-data="{ whoSlideEs: 0, whoTotalEs: {{ $whoCount }}, whoIntEs: null,
                                                                 initWhoEs() { this.whoIntEs = setInterval(() => { this.whoSlideEs = (this.whoSlideEs + 1) % this.whoTotalEs; }, 4000); },
                                                                 stopWhoEs() { clearInterval(this.whoIntEs); },
                                                                 startWhoEs() { this.stopWhoEs(); this.whoIntEs = setInterval(() => { this.whoSlideEs = (this.whoSlideEs + 1) % this.whoTotalEs; }, 4000); }
                                                             }" x-init="initWhoEs()" @mouseenter="stopWhoEs()"
                                    @mouseleave="startWhoEs()">
                                    @foreach($whoCarousel as $wi => $wImg)
                                        <img src="{{ $whoFromStorage ? asset('storage/' . $wImg) : asset($wImg) }}"
                                            alt="Sobre NSG {{ $wi + 1 }}"
                                            class="absolute inset-0 w-full h-full object-contain transition-opacity duration-1000 ease-in-out rounded-2xl"
                                            :class="whoSlideEs === {{ $wi }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                    @endforeach
                                    <button
                                        @click="stopWhoEs(); whoSlideEs = (whoSlideEs - 1 + whoTotalEs) % whoTotalEs; startWhoEs()"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button @click="stopWhoEs(); whoSlideEs = (whoSlideEs + 1) % whoTotalEs; startWhoEs()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5">
                                        @for($wd = 0; $wd < $whoCount; $wd++)
                                            <button @click="stopWhoEs(); whoSlideEs = {{ $wd }}; startWhoEs()"
                                                class="w-2 h-2 rounded-full transition-all duration-300"
                                                :class="whoSlideEs === {{ $wd }} ? 'bg-white w-5 rounded-full' : 'bg-white/40 hover:bg-white/60'"></button>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-slate-600 leading-relaxed">Con el fin de ofrecer el más alto nivel de
                                    experiencia y apoyo en nuestras operaciones, contratamos a algunas de las organizaciones
                                    más prestigiosas del mundo para trabajar junto con las comunidades locales de los países
                                    anfitriones. Todos colaboramos para promover la libertad, la democracia, el estado de
                                    derecho, el orden y el desarrollo de los pueblos oprimidos alrededor del mundo,
                                    generando así nuevas oportunidades para el desarrollo de estas naciones.</p>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- VISION --}}
                <div x-show="activeTab === 'vision'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    x-cloak>
                    <div class="bg-slate-50 rounded-3xl p-6 sm:p-8 md:p-12 border border-slate-200 shadow-xl">
                        <template x-if="$store.lang.current === 'en'">
                            <div>
                                <p class="text-slate-800 text-lg leading-relaxed mb-6">Become a key global partner
                                    so that all nations may have the best opportunity for a democratic governance
                                    with rule of law, national order, fair justice, equal opportunities and
                                    individual as well as global development of their country.</p>
                                <p class="text-slate-600 leading-relaxed">This in order to create a better platform
                                    for global peace, unity, financial stability, open and fair trade, better health
                                    and functional collaboration in all aspects of global issues.</p>
                            </div>
                        </template>
                        <template x-if="$store.lang.current === 'es'">
                            <div>
                                <p class="text-slate-800 text-lg leading-relaxed mb-6">Convertirnos en un socio
                                    global clave para que todas las naciones tengan la mejor oportunidad de alcanzar
                                    una gobernanza democrática con estado de derecho, orden nacional, justicia
                                    equitativa, igualdad de oportunidades y desarrollo tanto individual como global.
                                </p>
                                <p class="text-slate-600 leading-relaxed">Esto con el propósito de crear una mejor
                                    plataforma para la paz mundial, la unidad, la estabilidad financiera, el
                                    comercio abierto y justo, una mejor salud y una colaboración funcional en todos
                                    los aspectos de los desafíos globales.</p>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- MISSION --}}
                <div x-show="activeTab === 'mission'" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                    x-cloak>
                    <div class="bg-slate-50 rounded-3xl p-6 sm:p-8 md:p-12 border border-slate-200 shadow-xl">
                        <template x-if="$store.lang.current === 'en'">
                            <div>
                                <p class="text-slate-800 text-lg leading-relaxed mb-6">Use real world expertise in
                                    order to evaluate, recommend and create solutions as your end-to-end partner,
                                    while we also help to execute on the recommendations of our team of Global
                                    Experts.</p>
                                <p class="text-slate-600 leading-relaxed mb-6">To train and develop custom solutions
                                    while cultivating education, professionalism, trust, honor and pride thus the
                                    Host Nations empowerment of common global as well as individual success.</p>
                                <p class="text-slate-800 font-semibold mb-4">Applying, monitoring and managing
                                    through our proven Team of Teams Framework:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach(['Shared Knowledge', 'Common Purpose', 'Accountability', 'Trust', 'Empowerment', 'Continued Assessment', 'Global Development'] as $val)
                                        <div
                                            class="flex items-center gap-2 bg-white rounded-lg px-3 py-2 border border-slate-200 shadow-sm">
                                            <svg class="w-4 h-4 text-accent-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-slate-700 text-sm font-semibold">{{ $val }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </template>
                        <template x-if="$store.lang.current === 'es'">
                            <div>
                                <p class="text-slate-800 text-lg leading-relaxed mb-6">Aplicar experiencia del mundo
                                    real para evaluar, recomendar y desarrollar soluciones como su socio integral,
                                    además de colaborar en la ejecución de las recomendaciones de nuestro equipo
                                    global de expertos.</p>
                                <p class="text-slate-600 leading-relaxed mb-6">Capacitar y desarrollar soluciones
                                    personalizadas, fomentando la educación, el profesionalismo, la confianza, el
                                    honor y el orgullo, promoviendo así el empoderamiento de los países anfitriones
                                    hacia el éxito global e individual.</p>
                                <p class="text-slate-800 font-semibold mb-4">Aplicamos, supervisamos y gestionamos
                                    mediante nuestro marco comprobado de "Equipo de Equipos":</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3">
                                    @foreach(['Conocimiento Compartido', 'Propósito Común', 'Responsabilidad', 'Confianza', 'Empoderamiento', 'Evaluación Continua', 'Desarrollo Global'] as $val)
                                        <div
                                            class="flex items-center gap-2 bg-white rounded-lg px-3 py-2 border border-slate-200 shadow-sm">
                                            <svg class="w-4 h-4 text-accent-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M5 13l4 4L19 7" />
                                            </svg>
                                            <span class="text-slate-700 text-sm font-semibold">{{ $val }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Media: Video for Who, Images for Vision/Mission --}}
                <div class="mt-12" data-animate>
                    {{-- Who We Are - Video --}}
                    <div x-show="activeTab === 'who'" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                        @php
                            $whoVideo = $whoSection->video_url ?? 'https://www.youtube.com/embed/Tu_3BNY2dGg';
                            preg_match('/(?:[?&]v=|youtu\.be\/|embed\/|shorts\/)([^?&]+)/', $whoVideo, $whoYtM);
                            $whoYtId = $whoYtM[1] ?? null;
                            $whoEmbedUrl = $whoYtId ? 'https://www.youtube.com/embed/' . $whoYtId : $whoVideo;
                        @endphp
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-black/10 aspect-video">
                            <iframe class="w-full h-full" src="{{ $whoEmbedUrl }}" title="About NSG" frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen></iframe>
                        </div>
                    </div>

                    {{-- Vision - Carousel --}}
                    @php $visionSection = $aboutSections->firstWhere('tab_key', 'vision'); @endphp
                    @php
                        $visionCarousel = [
                            asset('images/carrusel7.png'),
                            asset('images/carrusel8.png'),
                            asset('images/carrusel6.png'),
                        ];
                        $visionCarouselEs = $visionSection && $visionSection->carousel_images_es && count($visionSection->carousel_images_es) > 0
                            ? array_map(fn($img) => asset('storage/' . $img), $visionSection->carousel_images_es)
                            : null;
                        $visionCount = count($visionCarousel);
                        $visionCountEs = $visionCarouselEs ? count($visionCarouselEs) : 0;
                    @endphp
                    <div x-show="activeTab === 'vision'" x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        x-cloak>
                        <div class="relative rounded-2xl overflow-hidden shadow-2xl shadow-black/10 aspect-video">
                            {{-- English carousel (or default if no Spanish version) --}}
                            <div class="absolute inset-0" @if($visionCarouselEs) x-show="$store.lang.current === 'en'"
                            x-transition.opacity.duration.500ms @endif>
                                <div class="absolute inset-0" x-data="{ visSlide: 0, visTotal: {{ $visionCount }}, visInt: null,
                                                                 initVis() { this.visInt = setInterval(() => { this.visSlide = (this.visSlide + 1) % this.visTotal; }, 4000); },
                                                                 stopVis() { clearInterval(this.visInt); },
                                                                 startVis() { this.stopVis(); this.visInt = setInterval(() => { this.visSlide = (this.visSlide + 1) % this.visTotal; }, 4000); }
                                                             }" x-init="initVis()" @mouseenter="stopVis()"
                                    @mouseleave="startVis()">
                                    @foreach($visionCarousel as $vi => $vImg)
                                        <img src="{{ $vImg }}" alt="Vision {{ $vi + 1 }}"
                                            class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out"
                                            :class="visSlide === {{ $vi }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                    @endforeach
                                    {{-- Arrows --}}
                                    <button @click="stopVis(); visSlide = (visSlide - 1 + visTotal) % visTotal; startVis()"
                                        class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button @click="stopVis(); visSlide = (visSlide + 1) % visTotal; startVis()"
                                        class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                    {{-- Dots --}}
                                    <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5">
                                        @for($vd = 0; $vd < $visionCount; $vd++)
                                            <button @click="stopVis(); visSlide = {{ $vd }}; startVis()"
                                                class="w-2 h-2 rounded-full transition-all duration-300"
                                                :class="visSlide === {{ $vd }} ? 'bg-white w-5 rounded-full' : 'bg-white/40 hover:bg-white/60'"></button>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            @if($visionCarouselEs)
                                {{-- Spanish carousel --}}
                                <div class="absolute inset-0" x-show="$store.lang.current === 'es'"
                                    x-transition.opacity.duration.500ms x-cloak>
                                    <div class="absolute inset-0" x-data="{ visSlideEs: 0, visTotalEs: {{ $visionCountEs }}, visIntEs: null,
                                                                                         initVisEs() { this.visIntEs = setInterval(() => { this.visSlideEs = (this.visSlideEs + 1) % this.visTotalEs; }, 4000); },
                                                                                         stopVisEs() { clearInterval(this.visIntEs); },
                                                                                         startVisEs() { this.stopVisEs(); this.visIntEs = setInterval(() => { this.visSlideEs = (this.visSlideEs + 1) % this.visTotalEs; }, 4000); }
                                                                                     }" x-init="initVisEs()"
                                        @mouseenter="stopVisEs()" @mouseleave="startVisEs()">
                                        @foreach($visionCarouselEs as $vei => $veImg)
                                            <img src="{{ $veImg }}" alt="Visión {{ $vei + 1 }}"
                                                class="absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 ease-in-out"
                                                :class="visSlideEs === {{ $vei }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                                        @endforeach
                                        <button
                                            @click="stopVisEs(); visSlideEs = (visSlideEs - 1 + visTotalEs) % visTotalEs; startVisEs()"
                                            class="absolute left-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 19l-7-7 7-7" />
                                            </svg>
                                        </button>
                                        <button @click="stopVisEs(); visSlideEs = (visSlideEs + 1) % visTotalEs; startVisEs()"
                                            class="absolute right-3 top-1/2 -translate-y-1/2 z-20 w-9 h-9 rounded-full bg-black/30 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white hover:bg-black/50 transition-all">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5l7 7-7 7" />
                                            </svg>
                                        </button>
                                        <div class="absolute bottom-3 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5">
                                            @for($ved = 0; $ved < $visionCountEs; $ved++)
                                                <button @click="stopVisEs(); visSlideEs = {{ $ved }}; startVisEs()"
                                                    class="w-2 h-2 rounded-full transition-all duration-300"
                                                    :class="visSlideEs === {{ $ved }} ? 'bg-white w-5 rounded-full' : 'bg-white/40 hover:bg-white/60'"></button>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- Gradient overlay --}}
                            <div
                                class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent z-[15] pointer-events-none">
                            </div>
                            <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8 z-[16]">
                                <p class="text-white text-lg md:text-2xl font-display font-semibold max-w-xl"
                                    x-text="$store.lang.current === 'en' ? '{{ addslashes($visionSection->caption_en ?? 'Transforming nations through development, opportunity, and global collaboration.') }}' : '{{ addslashes($visionSection->caption_es ?? 'Transformando naciones a través del desarrollo, la oportunidad y la colaboración global.') }}'">
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Mission - Image removed per request --}}
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================
    SERVICES & CURRENT PROJECTS — Tabbed Corporate Layout
    ============================================================ --}}
    <section class="relative py-24 lg:py-32 bg-[#070B14] text-white overflow-hidden" id="services"
        x-data="{ svcTab: 'services' }" @set-svc-tab.window="svcTab = $event.detail.tab"
        x-show="$store.sections.active === 'services'" x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            {{-- Section Header --}}
            <div class="mb-10 lg:mb-14" data-animate>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-10 h-[2px] bg-accent-500"></div>
                    <span class="text-accent-400 text-xs font-bold tracking-[0.2em] uppercase"
                        x-text="$store.lang.current === 'en' ? 'What We Do' : 'Lo Que Hacemos'"></span>
                </div>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-display font-bold text-white leading-tight">
                    <span x-show="$store.lang.current === 'en'">Our <span class="text-accent-400">Services</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Nuestros <span
                            class="text-accent-400">Servicios</span></span>
                </h2>
            </div>

            {{-- Tab Navigation --}}
            <div class="flex items-center gap-1 mb-10 border-b border-white/[0.08]">
                <button @click="svcTab = 'services'"
                    :class="svcTab === 'services' ? 'text-white border-accent-500 bg-accent-500/[0.06]' : 'text-white/40 border-transparent hover:text-white/70 hover:bg-white/[0.03]'"
                    class="relative px-6 py-3 text-sm font-semibold tracking-wide border-b-2 transition-all duration-300 rounded-t-lg">
                    <span x-text="$store.lang.current === 'en' ? 'Services' : 'Servicios'"></span>
                </button>
                <button @click="svcTab = 'projects'"
                    :class="svcTab === 'projects' ? 'text-white border-accent-500 bg-accent-500/[0.06]' : 'text-white/40 border-transparent hover:text-white/70 hover:bg-white/[0.03]'"
                    class="relative px-6 py-3 text-sm font-semibold tracking-wide border-b-2 transition-all duration-300 rounded-t-lg">
                    <span x-text="$store.lang.current === 'en' ? 'Current Projects' : 'Proyectos Actuales'"></span>
                </button>
            </div>

            {{-- TAB 1: Services Grid --}}
            <div x-show="svcTab === 'services'" x-transition:enter="transition ease-out duration-400"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6">
                    @foreach($services as $idx => $svc)
                        <div class="group relative bg-[#0C1220] rounded-lg border border-white/[0.06] hover:border-white/[0.12] transition-all duration-400 overflow-hidden"
                            style="animation: svcReveal 0.5s ease-out {{ $idx * 0.04 }}s both;">
                            <div class="flex flex-col sm:flex-row h-full">
                                {{-- Left: Image --}}
                                <div
                                    class="relative w-full sm:w-[44%] min-h-[200px] sm:min-h-[240px] overflow-hidden shrink-0 bg-[#0A0F1A]">
                                    @if($svc->image)
                                        <img src="{{ asset($svc->image) }}" alt="{{ $svc->name_en }}"
                                            class="absolute inset-0 w-full h-full object-cover opacity-85 group-hover:opacity-100 transition-all duration-500 group-hover:scale-[1.04]"
                                            loading="lazy">
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-br from-[#111827] to-[#0C1220]"></div>
                                    @endif
                                    <div
                                        class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-[#0C1220] to-transparent hidden sm:block">
                                    </div>
                                    <div
                                        class="absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-[#0C1220] to-transparent sm:hidden">
                                    </div>
                                </div>
                                {{-- Right: Content --}}
                                <div class="flex-1 p-6 sm:p-8 flex flex-col justify-center min-w-0">
                                    <h3 class="text-white font-bold text-[17px] sm:text-lg lg:text-xl leading-snug mb-3 group-hover:text-white/95 transition-colors duration-300"
                                        x-text="$store.lang.current === 'en' ? '{{ addslashes($svc->name_en) }}' : '{{ addslashes($svc->name_es) }}'">
                                    </h3>
                                    <div
                                        class="w-10 h-[2px] bg-accent-500/50 group-hover:w-16 group-hover:bg-accent-500 transition-all duration-400 mb-3">
                                    </div>
                                    @if($svc->short_description)
                                        <p class="text-white/60 text-sm font-bold leading-relaxed line-clamp-2">
                                            {{ $svc->short_description }}
                                        </p>
                                    @else
                                        <p class="text-white/50 text-xs font-bold uppercase tracking-[0.15em]"
                                            x-text="$store.lang.current === 'en' ? 'Specialized Service' : 'Servicio Especializado'">
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- TAB 2: Current Projects Grid (Grouped by Category) --}}
            <div x-show="svcTab === 'projects'" x-cloak x-transition:enter="transition ease-out duration-400"
                x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0">
                @if($currentProjects->count() > 0)
                    @php
                        $grouped = $currentProjects->groupBy('category');
                        $categoryOrder = ['proposed_sm_mid_large', 'classified', 'proposed_mega'];
                        $catLabels = [
                            'proposed_sm_mid_large' => ['en' => 'PROPOSED PROJECTS: SMALL, MEDIUM & LARGE', 'es' => 'PROYECTOS PROPUESTOS: PEQUEÑOS, MEDIANOS Y GRANDES'],

                            'proposed_mega' => ['en' => 'PROPOSED MEGA PROJECTS', 'es' => 'MEGA PROYECTOS PROPUESTOS'],
                        ];
                        $globalIdx = 0;
                    @endphp

                    @foreach($categoryOrder as $cat)
                        @if(isset($grouped[$cat]) && $grouped[$cat]->count() > 0)

                            {{-- Category Header --}}
                            @if($cat === 'proposed_sm_mid_large')
                                <div class="flex items-center gap-3 mb-6"
                                    style="animation: svcReveal 0.5s ease-out {{ $globalIdx * 0.04 }}s both;">
                                    <div class="w-8 h-[2px] bg-accent-500"></div>
                                    <h4 class="text-accent-400 text-xs font-bold tracking-[0.2em] uppercase"
                                        x-text="$store.lang.current === 'en' ? '{{ $catLabels[$cat]['en'] }}' : '{{ $catLabels[$cat]['es'] }}'">
                                    </h4>
                                </div>

                            @elseif($cat === 'proposed_mega')
                                <div class="mt-14 mb-8" style="animation: svcReveal 0.5s ease-out {{ $globalIdx * 0.04 }}s both;">
                                    <div class="text-center">
                                        <div
                                            class="inline-flex items-center gap-3 px-6 py-3 rounded-xl bg-gradient-to-r from-accent-500/10 via-accent-500/5 to-accent-500/10 border border-accent-500/20 mb-4">
                                            <svg class="w-5 h-5 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                            </svg>
                                            <span class="text-accent-400 text-xs font-bold tracking-[0.2em] uppercase"
                                                x-text="$store.lang.current === 'en' ? '{{ $catLabels[$cat]['en'] }}' : '{{ $catLabels[$cat]['es'] }}'"></span>
                                        </div>
                                        <div class="w-20 h-[2px] bg-accent-500/40 mx-auto"></div>
                                    </div>
                                </div>
                            @endif

                            {{-- Project Cards Grid --}}
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-6 {{ $cat !== 'proposed_mega' ? 'mb-4' : '' }}">
                                @foreach($grouped[$cat] as $proj)
                                    <div class="group relative bg-[#0C1220] rounded-lg border border-white/[0.06] hover:border-white/[0.12] transition-all duration-400 overflow-hidden"
                                        style="animation: svcReveal 0.5s ease-out {{ $globalIdx * 0.06 }}s both;">
                                        <div class="flex flex-col sm:flex-row h-full">
                                            {{-- Left: Image --}}
                                            <div
                                                class="relative w-full sm:w-[44%] min-h-[200px] sm:min-h-[240px] overflow-hidden shrink-0 bg-[#0A0F1A]">
                                                @if($proj->image)
                                                    <img src="{{ asset('storage/' . $proj->image) }}" alt="{{ $proj->name_en }}"
                                                        class="absolute inset-0 w-full h-full object-cover opacity-85 group-hover:opacity-100 transition-all duration-500 group-hover:scale-[1.04]"
                                                        loading="lazy">
                                                @else
                                                    <div class="absolute inset-0 bg-gradient-to-br from-[#1a1a2e] to-[#0C1220]"></div>
                                                    <div class="absolute inset-0 flex items-center justify-center">
                                                        <div class="w-16 h-16 rounded-full bg-white/[0.04] flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-white/20" fill="none" viewBox="0 0 24 24"
                                                                stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                            </svg>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div
                                                    class="absolute inset-y-0 right-0 w-16 bg-gradient-to-l from-[#0C1220] to-transparent hidden sm:block">
                                                </div>
                                                <div
                                                    class="absolute inset-x-0 bottom-0 h-10 bg-gradient-to-t from-[#0C1220] to-transparent sm:hidden">
                                                </div>
                                                {{-- Status badge --}}
                                                <div class="absolute top-3 left-3 z-10">
                                                    @if($proj->status === 'active')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-emerald-500/20 border border-emerald-500/30 text-emerald-400 text-[10px] font-bold uppercase tracking-wider">
                                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                                            <span x-text="$store.lang.current === 'en' ? 'Active' : 'Activo'"></span>
                                                        </span>
                                                    @elseif($proj->status === 'upcoming')
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-amber-500/20 border border-amber-500/30 text-amber-400 text-[10px] font-bold uppercase tracking-wider">
                                                            <span x-text="$store.lang.current === 'en' ? 'Upcoming' : 'Próximo'"></span>
                                                        </span>
                                                    @else
                                                        <span
                                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md bg-white/10 border border-white/20 text-white/60 text-[10px] font-bold uppercase tracking-wider">
                                                            <span x-text="$store.lang.current === 'en' ? 'Completed' : 'Completado'"></span>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            {{-- Right: Content --}}
                                            <div class="flex-1 p-6 sm:p-8 flex flex-col justify-center min-w-0">
                                                {{-- Location --}}
                                                @if($proj->location_en)
                                                    <p class="text-accent-400 text-[11px] font-extrabold uppercase tracking-[0.15em] mb-2"
                                                        x-text="$store.lang.current === 'en' ? '{{ addslashes($proj->location_en) }}' : '{{ addslashes($proj->location_es) }}'">
                                                    </p>
                                                @endif
                                                <h3 class="text-white font-bold text-[17px] sm:text-lg lg:text-xl leading-snug mb-3 group-hover:text-white/95 transition-colors duration-300"
                                                    x-text="$store.lang.current === 'en' ? '{{ addslashes($proj->name_en) }}' : '{{ addslashes($proj->name_es) }}'">
                                                </h3>
                                                <div
                                                    class="w-10 h-[2px] bg-accent-500/50 group-hover:w-16 group-hover:bg-accent-500 transition-all duration-400 mb-3">
                                                </div>
                                                @if($proj->description_en)
                                                    @if($cat === 'proposed_mega')
                                                        <div x-data="{ expanded: false }">
                                                            <div class="text-white/60 text-sm font-bold leading-relaxed transition-all duration-300 overflow-hidden"
                                                                :style="expanded ? 'max-height: 1000px' : 'max-height: 9em'"
                                                                x-html="window.formatProjectDesc($store.lang.current === 'en' ? '{{ addslashes($proj->description_en) }}' : '{{ addslashes($proj->description_es) }}')">
                                                            </div>
                                                            <button @click="expanded = !expanded"
                                                                class="mt-2 text-accent-400 text-xs font-bold hover:text-accent-300 transition-colors duration-200 flex items-center gap-1">
                                                                <span x-text="expanded ? ($store.lang.current === 'en' ? 'Show less' : 'Ver menos') : ($store.lang.current === 'en' ? 'Read more' : 'Leer más')"></span>
                                                                <svg class="w-3 h-3 transition-transform duration-200" :class="expanded ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                                </svg>
                                                            </button>
                                                        </div>
                                                    @else
                                                        <div class="text-white/60 text-sm font-bold leading-relaxed"
                                                            x-html="window.formatProjectDesc($store.lang.current === 'en' ? '{{ addslashes($proj->description_en) }}' : '{{ addslashes($proj->description_es) }}')">
                                                        </div>
                                                    @endif
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @php $globalIdx++; @endphp
                                @endforeach
                            </div>

                        @endif
                    @endforeach
                @else
                    <div class="text-center py-20">
                        <p class="text-white/30 text-lg"
                            x-text="$store.lang.current === 'en' ? 'No current projects to display.' : 'No hay proyectos actuales para mostrar.'">
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <style>
            @keyframes svcReveal {
                from {
                    opacity: 0;
                    transform: translateY(16px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
        </style>
    </section>

    {{-- ============================================================
    OPPORTUNITIES
    ============================================================ --}}
    <section class="relative py-24 bg-white" id="opportunities" x-data x-show="$store.sections.active === 'opportunities'"
        x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-animate>
                <span class="text-accent-500 text-lg font-bold tracking-wider uppercase mb-4 block"
                    x-text="$store.lang.current === 'en' ? 'Opportunities' : 'Oportunidades'"></span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-slate-900 leading-tight mb-4">
                    <span x-show="$store.lang.current === 'en'">Positions <span
                            class="text-accent-500">Available</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Posiciones <span
                            class="text-accent-500">Disponibles</span></span>
                </h2>
            </div>

            @php
                $positionImages = [
                    'Law and Government' => ['law and government.jpg'],
                    'Ley y Gobierno' => ['law and government.jpg'],
                    'Intelligence' => ['intelligence.jpg'],
                    'Inteligencia' => ['intelligence.jpg'],
                    'Law Enforcement' => ['law enfrocement.jpg'],
                    'Cumplimiento de la Ley' => ['law enfrocement.jpg'],
                    'Aircraft Operations & Transportation' => ['aircraft operations.jpg'],
                    'Operaciones Aéreas y Transporte' => ['aircraft operations.jpg'],
                    'Construction & Civil Engineering' => ['construction and civil engineering.jpg'],
                    'Construcción e Ingeniería Civil' => ['construction and civil engineering.jpg'],
                    'Emergency Services' => ['emergency services.jpg'],
                    'Servicios de Emergencia' => ['emergency services.jpg'],
                    'Healthcare' => ['health care.jpg'],
                    'Salud' => ['health care.jpg'],
                    'Communications' => ['communications.jpg'],
                    'Comunicaciones' => ['communications.jpg'],
                    'Security, Protection & Military' => ['security, protection and military.jpg', 'security, protection and military2.jpg', 'security, protection and military3.jpg'],
                    'Seguridad, Protección y Militar' => ['security, protection and military.jpg', 'security, protection and military2.jpg', 'security, protection and military3.jpg'],
                    'Finances' => ['finance.jpg'],
                    'Finanzas' => ['finance.jpg'],
                ];
            @endphp

            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6" data-animate data-stagger>
                @foreach($positionCategories as $pos)
                    @php
                        $imgs = $positionImages[$pos->name_en] ?? $positionImages[$pos->name_es] ?? null;
                        $img = $imgs ? $imgs[0] : null;
                    @endphp
                    <a href="/careers"
                        class="group relative overflow-hidden rounded-2xl cursor-pointer transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl h-64"
                        @if($imgs && count($imgs) > 1)
                            x-data="{ slide: 0, images: {{ json_encode(array_map(fn($i) => asset('images/' . $i), $imgs)) }}, init() { setInterval(() => { this.slide = (this.slide + 1) % this.images.length }, 2000) } }"
                        @endif>
                        {{-- Background Image --}}
                        @if($imgs && count($imgs) > 1)
                            {{-- Multi-image carousel --}}
                            @foreach($imgs as $idx => $imgFile)
                                <div class="absolute inset-0 bg-cover bg-center transition-all duration-1000 group-hover:scale-110"
                                    :class="slide === {{ $idx }} ? 'opacity-100' : 'opacity-0'"
                                    style="background-image: url('{{ asset('images/' . $imgFile) }}');"></div>
                            @endforeach
                        @elseif($img)
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110"
                                style="background-image: url('{{ asset('images/' . $img) }}');"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-slate-900"></div>
                        @endif
                        {{-- Overlay --}}
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-black/10 group-hover:from-black/90 group-hover:via-black/50 transition-all duration-500">
                        </div>
                        {{-- Icon + Text --}}
                        <div class="relative z-10 flex flex-col justify-end h-full p-6">
                            <div
                                class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white mb-4 group-hover:bg-accent-500 group-hover:border-accent-500 transition-all duration-300">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="{{ $pos->icon_svg }}" />
                                </svg>
                            </div>
                            <h3 class="font-display font-bold text-lg text-white leading-snug"
                                x-text="$store.lang.current === 'en' ? '{{ addslashes($pos->name_en) }}' : '{{ addslashes($pos->name_es) }}'">
                            </h3>
                            <div
                                class="mt-3 flex items-center gap-2 text-accent-400 text-sm font-semibold opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                <span x-text="$store.lang.current === 'en' ? 'View Positions' : 'Ver Posiciones'"></span>
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                </svg>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>


    {{-- ============================================================
    RELEVANT EVENTS
    ============================================================ --}}
    <section class="relative py-24 bg-slate-50" id="events" x-data x-show="$store.sections.active === 'events'"
        x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-animate>
                <span class="text-accent-500 text-sm font-bold tracking-wider uppercase mb-4 block"
                    x-text="$store.lang.current === 'en' ? 'Where We Operate' : 'Donde Operamos'"></span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-slate-900 leading-tight">
                    <span x-show="$store.lang.current === 'en'">Relevant <span class="text-accent-500">Events</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Eventos <span
                            class="text-accent-500">Relevantes</span></span>
                </h2>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-animate data-stagger
                x-data="{ mediaOpen: false, mediaType: '', mediaUrl: '', mediaTitle: '' }">
                @foreach($events as $event)
                    <div @if($event->media_type !== 'none' && $event->media_url)
                        @click="mediaType = '{{ $event->media_type }}'; mediaUrl = '{{ $event->media_type === 'youtube' ? $event->media_url : asset('storage/' . $event->media_url) }}'; mediaTitle = $store.lang.current === 'en' ? '{{ addslashes($event->name_en) }}' : '{{ addslashes($event->name_es) }}'; mediaOpen = true"
                    @endif
                        class="group relative overflow-hidden rounded-2xl cursor-pointer transition-all duration-500 hover:-translate-y-2 hover:shadow-2xl">
                        <div class="{{ $event->gradient_classes }} h-72 flex items-end p-6 relative overflow-hidden">
                            @if($event->thumbnail_image)
                                {{-- Custom thumbnail takes priority --}}
                                <img src="{{ asset('storage/' . $event->thumbnail_image) }}" alt="{{ $event->name_en }}"
                                    class="absolute inset-0 w-full h-full object-cover">
                            @elseif($event->media_type === 'image' && $event->media_url)
                                <img src="{{ asset('storage/' . $event->media_url) }}" alt="{{ $event->name_en }}"
                                    class="absolute inset-0 w-full h-full object-cover">
                            @elseif($event->media_type === 'youtube' && $event->media_url)
                                @php
                                    preg_match('/(?:[?&]v=|youtu\.be\/|embed\/|shorts\/)([^?&]+)/', $event->media_url, $ytMatch);
                                    $ytId = $ytMatch[1] ?? null;
                                @endphp
                                @if($ytId)
                                    <img src="https://img.youtube.com/vi/{{ $ytId }}/hqdefault.jpg" alt="{{ $event->name_en }}"
                                        class="absolute inset-0 w-full h-full object-cover">
                                @endif
                            @endif
                            <div class="absolute top-4 right-4 text-4xl z-20">{{ $event->emoji }}</div>
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
                            @if($event->media_type !== 'none' && $event->media_url)
                                <div
                                    class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                    <div
                                        class="w-16 h-16 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center">
                                        @if($event->media_type === 'image')
                                            <svg class="w-7 h-7 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        @else
                                            <svg class="w-8 h-8 text-white ml-1" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M8 5v14l11-7z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                            @endif
                            <div class="relative z-10">
                                <h3 class="text-white font-display font-bold text-2xl"
                                    x-text="$store.lang.current === 'en' ? '{{ addslashes($event->name_en) }}' : '{{ addslashes($event->name_es) }}'">
                                </h3>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Media Modal --}}
                <div x-show="mediaOpen" x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                    x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/80 backdrop-blur-sm p-4"
                    @click.self="mediaOpen = false; mediaUrl = ''" @keydown.escape.window="mediaOpen = false; mediaUrl = ''"
                    x-cloak>
                    <div class="relative w-full max-w-4xl bg-black rounded-2xl overflow-hidden shadow-2xl"
                        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                        x-transition:enter-end="opacity-100 scale-100">
                        {{-- Close button --}}
                        <button @click="mediaOpen = false; mediaUrl = ''"
                            class="absolute top-4 right-4 z-50 w-10 h-10 rounded-full bg-black/50 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white hover:bg-black/70 transition-all">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        {{-- Title --}}
                        <div class="bg-gradient-to-b from-black/90 to-transparent absolute top-0 left-0 right-0 p-5 z-40">
                            <h3 class="text-white font-display font-bold text-xl" x-text="mediaTitle"></h3>
                        </div>
                        {{-- YouTube --}}
                        <template x-if="mediaType === 'youtube' && mediaOpen">
                            <div class="aspect-video">
                                <iframe :src="(() => {
                                                            let url = mediaUrl;
                                                            let id = '';
                                                            let m = url.match(/[?&]v=([^&]+)/) || url.match(/youtu\.be\/([^?&]+)/) || url.match(/embed\/([^?&]+)/) || url.match(/shorts\/([^?&]+)/);
                                                            if (m) id = m[1];
                                                            return id ? 'https://www.youtube.com/embed/' + id + '?autoplay=1' : url;
                                                        })()" class="w-full h-full" frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen></iframe>
                            </div>
                        </template>
                        {{-- Video --}}
                        <template x-if="mediaType === 'video' && mediaOpen">
                            <div class="aspect-video">
                                <video :src="mediaUrl" controls autoplay
                                    class="w-full h-full object-contain bg-black"></video>
                            </div>
                        </template>
                        {{-- Image --}}
                        <template x-if="mediaType === 'image' && mediaOpen">
                            <div class="flex items-center justify-center min-h-[300px] max-h-[80vh]">
                                <img :src="mediaUrl" :alt="mediaTitle" class="max-w-full max-h-[80vh] object-contain">
                            </div>
                        </template>
                    </div>
                </div>
            </div>
        </div>
    </section>


    {{-- ============================================================
    TESTIMONIALS — White Background with Image
    ============================================================ --}}
    <section class="relative py-24 bg-white overflow-hidden" id="testimonials" x-data
        x-show="$store.sections.active === 'testimonials'" x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <div class="text-center mb-14" data-animate>
                <span class="text-accent-500 text-lg font-bold tracking-wider uppercase mb-4 block"
                    x-text="$store.lang.current === 'en' ? 'Testimonials' : 'Testimonios'"></span>
                <p class="text-slate-500 text-lg max-w-2xl mx-auto"
                    x-text="$store.lang.current === 'en' ? 'A few of our beneficiaries in our global operations to free the oppressed and save the innocent.' : 'Algunos de nuestros beneficiarios en operaciones globales para liberar a los oprimidos y proteger a los inocentes.'">
                </p>
            </div>

            {{-- Testimonials --}}
            @foreach($testimonials as $idx => $testimonial)
                <div class="mb-8 last:mb-0" data-animate="scale">
                    <div
                        class="relative bg-slate-50 rounded-2xl border border-slate-100 overflow-hidden shadow-sm hover:shadow-md transition-shadow duration-300">

                        {{-- Top row: Image + Content side by side --}}
                        <div class="flex flex-col md:flex-row">

                            {{-- Left: Image (if available and no video) --}}
                            @if($testimonial->image && !$testimonial->video && !$testimonial->video_url)
                                <div class="relative w-full md:w-[32%] min-h-[200px] md:min-h-0 shrink-0 overflow-hidden">
                                    <img src="{{ asset('storage/' . $testimonial->image) }}" alt="{{ $testimonial->country_en }}"
                                        class="absolute inset-0 w-full h-full object-cover" loading="lazy">
                                    <div
                                        class="absolute inset-y-0 right-0 w-12 bg-gradient-to-l from-slate-50 to-transparent hidden md:block">
                                    </div>
                                    <div
                                        class="absolute inset-x-0 bottom-0 h-8 bg-gradient-to-t from-slate-50 to-transparent md:hidden">
                                    </div>
                                </div>
                            @endif

                            {{-- Right: Content --}}
                            <div class="flex-1 p-8 md:p-10 lg:p-12">
                                {{-- Country badge --}}
                                <span
                                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-accent-500/10 text-accent-500 text-xs font-bold uppercase tracking-wider mb-6">
                                    {{ $testimonial->country_emoji }}
                                    <span
                                        x-text="$store.lang.current === 'en' ? '{{ addslashes($testimonial->country_en) }}' : '{{ addslashes($testimonial->country_es) }}'"></span>
                                </span>

                                {{-- Testimonial text --}}
                                <template x-if="$store.lang.current === 'en'">
                                    <div
                                        class="prose prose-slate prose-base max-w-none [&>p]:mb-3 [&>p:last-child]:mb-0 [&_strong]:text-slate-800">
                                        {!! $testimonial->content_en !!}
                                    </div>
                                </template>
                                <template x-if="$store.lang.current === 'es'">
                                    <div
                                        class="prose prose-slate prose-base max-w-none [&>p]:mb-3 [&>p:last-child]:mb-0 [&_strong]:text-slate-800">
                                        {!! $testimonial->content_es !!}
                                    </div>
                                </template>

                                {{-- Author info --}}
                                @if($testimonial->author_name)
                                    <div class="mt-6 pt-5 border-t border-slate-200/80">
                                        <p class="text-slate-800 text-sm font-bold">{{ $testimonial->author_name }}</p>
                                        @if($testimonial->author_role_en)
                                            <p class="text-slate-400 text-xs mt-0.5"
                                                x-text="$store.lang.current === 'en' ? '{{ addslashes($testimonial->author_role_en) }}' : '{{ addslashes($testimonial->author_role_es) }}'">
                                            </p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Video section (below content) --}}
                        @if($testimonial->video || $testimonial->video_url)
                            <div class="px-6 pb-6 md:px-10 md:pb-10">
                                <div class="rounded-xl overflow-hidden bg-black shadow-lg">
                                    @if($testimonial->video)
                                        {{-- Uploaded video --}}
                                        <video controls preload="metadata" class="w-full max-h-[500px] object-contain bg-black"
                                            poster="{{ $testimonial->image ? asset('storage/' . $testimonial->image) : '' }}">
                                            <source src="{{ asset('storage/' . $testimonial->video) }}" type="video/mp4">
                                            Your browser does not support the video tag.
                                        </video>
                                    @elseif($testimonial->youtube_id)
                                        {{-- YouTube embed --}}
                                        <div class="relative w-full" style="padding-bottom: 56.25%;">
                                            <iframe src="https://www.youtube-nocookie.com/embed/{{ $testimonial->youtube_id }}"
                                                class="absolute inset-0 w-full h-full" frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen loading="lazy">
                                            </iframe>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            @endforeach
        </div>
    </section>



    {{-- ============================================================
    OUR PARTNERS (Aliados Estratégicos) - Redesigned Premium Layout
    ============================================================ --}}
    <section class="relative py-24 bg-gradient-to-b from-[#0a0a0a] via-[#111111] to-[#0a0a0a] text-white overflow-hidden"
        id="clients" x-data x-show="$store.sections.active === 'clients'"
        x-transition:enter="transition ease-out duration-700" x-transition:enter-start="opacity-0 translate-y-8"
        x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        {{-- Background effects --}}
        <div class="absolute inset-0">
            <div class="absolute top-1/4 left-1/4 w-[600px] h-[600px] bg-accent-500/5 rounded-full blur-[150px]"></div>
            <div class="absolute bottom-1/4 right-1/4 w-[400px] h-[400px] bg-blue-500/5 rounded-full blur-[120px]"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
            {{-- Section Header --}}
            <div class="text-center mb-20" data-animate="fade-up">
                <h2 class="text-4xl md:text-5xl font-display font-bold text-white leading-tight mb-4">
                    <span x-show="$store.lang.current === 'en'">Proud to <span class="text-accent-400">Work
                            With</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Orgullosos de <span class="text-accent-400">Trabajar
                            Con</span></span>
                </h2>
                <span class="text-blue-400 text-sm font-bold tracking-wider uppercase block mb-6">
                    <span x-show="$store.lang.current === 'en'"><span class="text-white">★</span> Support of the Following
                        <span class="text-white">★</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak><span class="text-white">★</span> Apoyo a los
                        Siguientes <span class="text-white">★</span></span>
                </span>
                <div class="w-20 h-0.5 bg-gradient-to-r from-transparent via-accent-500 to-transparent mx-auto"></div>
            </div>

            @php
                $insignias = [
                    0 => '1.png',
                    1 => '2.jpg',
                    2 => '3.png',
                    3 => '4.png',
                    4 => '5.png',
                    5 => '6.png',
                    6 => '7.png',
                    7 => '8.png',
                    8 => '9.png',
                    9 => '10.jpg',
                    10 => '11.png',
                    11 => '12.png',
                    12 => '13.png',
                    13 => '14.png',
                    14 => '15.png',
                    15 => '16.jpg',
                    16 => '17.png',
                    17 => '18.png',
                    18 => '19.png',
                    19 => '20.png',
                ];
            @endphp

            {{-- Client Grid --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 md:gap-5" data-animate
                data-stagger>
                @foreach($clients as $index => $client)
                    <div
                        class="group relative bg-white/[0.03] hover:bg-white/[0.08] border border-white/[0.06] hover:border-accent-500/30 rounded-2xl p-5 text-center transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_20px_60px_-15px_rgba(220,50,50,0.15)]">
                        <div class="relative w-20 h-20 md:w-24 md:h-24 mx-auto mb-4 flex items-center justify-center">
                            @if(isset($insignias[$index]))
                                <img src="{{ asset('images/' . $insignias[$index]) }}" alt="{{ $client->name_en }}"
                                    class="max-w-full max-h-full object-contain filter drop-shadow-lg group-hover:scale-110 transition-transform duration-500">
                            @else
                                <div
                                    class="w-16 h-16 rounded-full bg-accent-500/10 flex items-center justify-center text-accent-400 group-hover:bg-accent-500 group-hover:text-white transition-all duration-300">
                                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <p class="text-white/80 group-hover:text-white text-xs md:text-sm font-semibold leading-snug transition-colors duration-300"
                            x-text="$store.lang.current === 'en' ? '{{ addslashes($client->name_en) }}' : '{{ addslashes($client->name_es) }}'">
                        </p>
                        <div
                            class="absolute bottom-0 left-1/2 -translate-x-1/2 w-0 group-hover:w-3/4 h-[2px] bg-gradient-to-r from-transparent via-accent-500 to-transparent transition-all duration-500">
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Bottom text + NSG Logo --}}
            <div class="mt-20 text-center" data-animate="scale">
                <p class="text-white/60 text-lg max-w-3xl mx-auto leading-relaxed"
                    x-text="$store.lang.current === 'en' ? 'We are proud to provide world-class multidiscipline, multi-echelon trained talent to the U.S. Military and State Department, Law Enforcement, the Private Security Detail Sector, OGA Specialty Operator Teams as well as International Allied Forces.' : 'Nos enorgullece proporcionar talento de clase mundial, altamente capacitado en múltiples disciplinas y niveles, al Departamento de Defensa y al Departamento de Estado de EE.UU., a las fuerzas del orden, al sector de seguridad privada, a equipos especializados de operadores de agencias gubernamentales, así como a fuerzas aliadas internacionales.'">
                </p>
            </div>
        </div>
    </section>




    {{-- ============================================================
    CONTACT US
    ============================================================ --}}
    <section class="relative py-24 bg-white overflow-hidden" id="contact" x-data
        x-show="$store.sections.active === 'contact'" x-transition:enter="transition ease-out duration-700"
        x-transition:enter-start="opacity-0 translate-y-8" x-transition:enter-end="opacity-100 translate-y-0" x-cloak>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16" data-animate>
                <span class="text-accent-500 text-sm font-bold tracking-wider uppercase mb-4 block"
                    x-text="$store.lang.current === 'en' ? 'Contact Us' : 'Contáctenos'"></span>
                <h2 class="text-4xl md:text-5xl font-display font-bold text-slate-900 leading-tight mb-6">
                    <span x-show="$store.lang.current === 'en'">Get In <span class="text-accent-500">Touch</span></span>
                    <span x-show="$store.lang.current === 'es'" x-cloak>Ponte en <span
                            class="text-accent-500">Contacto</span></span>
                </h2>
                <p class="text-slate-500 text-lg max-w-xl mx-auto"
                    x-text="$store.lang.current === 'en' ? 'To help us improve and serve you better, please drop us a line.' : 'Para ayudarnos a mejorar y brindarle un mejor servicio, por favor contáctenos.'">
                </p>
            </div>

            @php $hasOffices = isset($offices) && $offices->count() > 0; @endphp

            <div class="{{ $hasOffices ? 'grid lg:grid-cols-5 gap-12' : 'max-w-2xl mx-auto' }}" data-animate>
                {{-- Contact Form --}}
                <div class="{{ $hasOffices ? 'lg:col-span-3' : '' }}">
                    @if(session('success'))
                        <div class="bg-green-50 border border-green-200 rounded-2xl p-6 mb-8">
                            <div class="flex items-center gap-3">
                                <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <p class="text-green-800 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('contact.submit') }}" method="POST"
                        class="space-y-6 {{ !$hasOffices ? 'text-center' : '' }}" id="homepage-contact-form">
                        @csrf
                        <div class="grid sm:grid-cols-2 gap-6">
                            <div class="text-left">
                                <label for="hp_name" class="block text-slate-700 text-sm font-semibold mb-2">
                                    <span x-show="$store.lang.current === 'en'">Full Name *</span>
                                    <span x-show="$store.lang.current === 'es'" x-cloak>Nombre Completo *</span>
                                </label>
                                <input type="text" id="hp_name" name="name" required value="{{ old('name') }}"
                                    class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20 focus:bg-white focus:outline-none transition-all">
                                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div class="text-left">
                                <label for="hp_email" class="block text-slate-700 text-sm font-semibold mb-2">
                                    <span x-show="$store.lang.current === 'en'">Email *</span>
                                    <span x-show="$store.lang.current === 'es'" x-cloak>Correo Electrónico *</span>
                                </label>
                                <input type="email" id="hp_email" name="email" required value="{{ old('email') }}"
                                    class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20 focus:bg-white focus:outline-none transition-all">
                                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="text-left">
                            <label for="hp_message" class="block text-slate-700 text-sm font-semibold mb-2">
                                <span x-show="$store.lang.current === 'en'">Message *</span>
                                <span x-show="$store.lang.current === 'es'" x-cloak>Mensaje *</span>
                            </label>
                            <textarea id="hp_message" name="message" rows="5" required
                                class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:border-accent-500 focus:ring-2 focus:ring-accent-500/20 focus:bg-white focus:outline-none transition-all resize-none">{{ old('message') }}</textarea>
                            @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <button type="submit"
                                class="inline-flex items-center gap-2 px-10 py-4 rounded-xl font-bold text-base bg-black text-white hover:bg-slate-800 shadow-lg transition-all duration-300 hover:-translate-y-0.5">
                                <span x-show="$store.lang.current === 'en'">Send Message</span>
                                <span x-show="$store.lang.current === 'es'" x-cloak>Enviar Mensaje</span>
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Office Details Sidebar (only if offices are active) --}}
                @if($hasOffices)
                    <div class="lg:col-span-2 space-y-6">
                        @foreach($offices as $office)
                            <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100">
                                <h3 class="text-slate-900 font-display font-semibold text-lg mb-1">{{ $office->name }}</h3>
                                @if($office->country)
                                    <span
                                        class="text-accent-500 text-xs font-semibold tracking-wide uppercase mb-4 block">{{ $office->country }}</span>
                                @else
                                    <div class="mb-4"></div>
                                @endif
                                <ul class="space-y-4">
                                    @if($office->address)
                                        <li class="flex items-start gap-3 text-slate-500">
                                            <svg class="w-5 h-5 text-accent-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            <span class="text-sm">{{ $office->address }}</span>
                                        </li>
                                    @endif
                                    @if($office->phone)
                                        <li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $office->phone) }}"
                                                class="flex items-center gap-3 text-slate-500 hover:text-accent-500 transition-colors text-sm"><svg
                                                    class="w-5 h-5 text-accent-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                                </svg>{{ $office->phone }}</a></li>
                                    @endif
                                    @if($office->email)
                                        <li><a href="mailto:{{ $office->email }}"
                                                class="flex items-center gap-3 text-slate-500 hover:text-accent-500 transition-colors text-sm"><svg
                                                    class="w-5 h-5 text-accent-500 shrink-0" fill="none" viewBox="0 0 24 24"
                                                    stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>{{ $office->email }}</a></li>
                                    @endif
                                </ul>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

<script>
    window.formatProjectDesc = function(text) {
        if (!text) return '';
        // Detect numbered patterns: "1. xxx" or "1) xxx"
        const numberedPattern = /\d+[\.\)]\s/;
        if (!numberedPattern.test(text)) {
            return '<p>' + text + '</p>';
        }
        // Split on numbered items like "1. ", "2. ", "1) ", "2) "
        const items = text.split(/\d+[\.\)]\s+/).filter(item => item.trim());
        if (items.length <= 1) {
            return '<p>' + text + '</p>';
        }
        let html = '<ul class="space-y-2 mt-1">';
        items.forEach(function(item) {
            html += '<li class="flex items-start gap-2.5">';
            html += '<span class="w-1.5 h-1.5 rounded-full bg-accent-500/70 mt-[7px] shrink-0"></span>';
            html += '<span>' + item.trim() + '</span>';
            html += '</li>';
        });
        html += '</ul>';
        return html;
    };
</script>

@endsection