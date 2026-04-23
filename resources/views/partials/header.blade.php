{{-- NSG Header — Navigation with Language Toggle --}}
@php $isHome = request()->is('/'); @endphp
<header x-data="{ mobileOpen: false, scrolled: false, aboutOpen: false, oppsOpen: false, isHome: {{ $isHome ? 'true' : 'false' }} }"
        x-init="
            const check = () => { scrolled = window.scrollY > 50 };
            check();
            window.addEventListener('scroll', check);
        "
        :class="isHome ? (scrolled ? 'bg-black/70 backdrop-blur-md shadow-lg shadow-black/40 border-b border-white/5' : 'bg-transparent') : 'bg-black shadow-lg shadow-black/40 border-b border-white/5'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
        id="main-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3 group shrink-0" id="logo-link">
                <img src="{{ asset('images/NSG.png') }}"
                     alt="National Security Group"
                     class="h-14 w-auto transition-all duration-300 drop-shadow-lg">
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden xl:flex items-center gap-0.5" id="desktop-nav">
                <a href="/"
                   class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300">
                    <span x-text="$store.lang.current === 'en' ? 'Home' : 'Inicio'"></span>
                </a>

                {{-- About Us Dropdown --}}
                <div class="relative" id="nav-about"
                     @mouseenter="aboutOpen = true"
                     @mouseleave="aboutOpen = false">
                    <button class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300 flex items-center gap-1">
                        <span x-text="$store.lang.current === 'en' ? 'About Us' : 'Sobre Nosotros'"></span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="aboutOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="aboutOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-0 pt-2 min-w-[220px] z-50"
                         x-cloak>
                        <div class="bg-black/95 backdrop-blur-xl border border-white/10 rounded-xl shadow-2xl shadow-black/50 py-2">
                            <a :href="isHome ? '#about' : '/#about'" @click="aboutOpen = false; if(isHome) $dispatch('set-about-tab', { tab: 'who' })" class="flex items-center gap-3 px-5 py-3 text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-semibold">
                                <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Who We Are' : 'Quiénes Somos'"></span>
                            </a>
                            <a :href="isHome ? '#about' : '/#about'" @click="aboutOpen = false; if(isHome) $dispatch('set-about-tab', { tab: 'vision' })" class="flex items-center gap-3 px-5 py-3 text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-semibold">
                                <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Vision' : 'Visión'"></span>
                            </a>
                            <a :href="isHome ? '#about' : '/#about'" @click="aboutOpen = false; if(isHome) $dispatch('set-about-tab', { tab: 'mission' })" class="flex items-center gap-3 px-5 py-3 text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-semibold">
                                <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Mission' : 'Misión'"></span>
                            </a>
                        </div>
                    </div>
                </div>

                <a :href="isHome ? '#services' : '/#services'" @click="if(isHome) { $event.preventDefault(); $store.sections.show('services') }"
                   class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300">
                    <span x-text="$store.lang.current === 'en' ? 'Services' : 'Servicios'"></span>
                </a>

                {{-- Opportunities Dropdown --}}
                <div class="relative" id="nav-opportunities"
                     @mouseenter="oppsOpen = true"
                     @mouseleave="oppsOpen = false">
                    <button class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300 flex items-center gap-1">
                        <span x-text="$store.lang.current === 'en' ? 'Opportunities' : 'Oportunidades'"></span>
                        <svg class="w-3.5 h-3.5 transition-transform" :class="oppsOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="oppsOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 translate-y-1"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0 translate-y-1"
                         class="absolute top-full left-0 pt-2 min-w-[200px] z-50"
                         x-cloak>
                        <div class="bg-black/95 backdrop-blur-xl border border-white/10 rounded-xl shadow-2xl shadow-black/50 py-2">
                            <a :href="isHome ? '#opportunities' : '/#opportunities'" @click="oppsOpen = false; if(isHome) { $event.preventDefault(); $store.sections.show('opportunities') }" class="flex items-center gap-3 px-5 py-3 text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-semibold">
                                <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Positions' : 'Posiciones'"></span>
                            </a>
                            <a href="/careers" @click="oppsOpen = false" class="flex items-center gap-3 px-5 py-3 text-white/80 hover:text-white hover:bg-white/10 transition-all text-sm font-semibold">
                                <svg class="w-4 h-4 text-accent-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span x-text="$store.lang.current === 'en' ? 'Apply' : 'Postular'"></span>
                            </a>
                        </div>
                    </div>
                </div>

                <a :href="isHome ? '#events' : '/#events'" @click="if(isHome) { $event.preventDefault(); $store.sections.show('events') }"
                   class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300">
                    <span x-text="$store.lang.current === 'en' ? 'Relevant Events' : 'Eventos Relevantes'"></span>
                </a>

                <a :href="isHome ? '#testimonials' : '/#testimonials'" @click="if(isHome) { $event.preventDefault(); $store.sections.show('testimonials') }"
                   class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300">
                    <span x-text="$store.lang.current === 'en' ? 'Testimonials' : 'Testimonios'"></span>
                </a>

                <a :href="isHome ? '#clients' : '/#clients'" @click="if(isHome) { $event.preventDefault(); $store.sections.show('clients') }"
                   class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300">
                    <span x-text="$store.lang.current === 'en' ? 'Clients' : 'Clientes'"></span>
                </a>

                <a :href="isHome ? '#contact' : '/#contact'" @click="if(isHome) { $event.preventDefault(); $store.sections.show('contact') }"
                   class="px-3 py-2 rounded-lg text-sm font-bold text-white hover:bg-white/10 transition-all duration-300">
                    <span x-text="$store.lang.current === 'en' ? 'Contact Us' : 'Contáctenos'"></span>
                </a>
            </nav>

            {{-- Right Side --}}
            <div class="hidden xl:flex items-center gap-2">
                {{-- Language Toggle Switch --}}
                <div class="flex items-center gap-2.5" id="lang-toggle-desktop">
                    <span class="text-xs font-bold tracking-wide transition-colors duration-300"
                          :class="$store.lang.current === 'es' ? 'text-white' : 'text-white/40'">Español</span>
                    <button @click="$store.lang.toggle()"
                            class="relative w-[52px] h-[28px] rounded-full transition-all duration-400 ease-in-out focus:outline-none focus:ring-2 focus:ring-white/30 focus:ring-offset-1 focus:ring-offset-transparent"
                            :class="$store.lang.current === 'en' ? 'bg-gradient-to-r from-red-600 to-red-700 shadow-lg shadow-red-600/30' : 'bg-gradient-to-r from-neutral-800 to-neutral-900 shadow-lg shadow-black/40 border border-white/10'"
                            :aria-label="$store.lang.current === 'en' ? 'Switch to Spanish' : 'Cambiar a Inglés'">
                        <span class="absolute top-[3px] left-[3px] w-[22px] h-[22px] bg-white rounded-full shadow-md transition-all duration-400 ease-in-out"
                              :style="$store.lang.current === 'en' ? 'transform: translateX(24px)' : 'transform: translateX(0)'"></span>
                    </button>
                    <span class="text-xs font-bold tracking-wide transition-colors duration-300"
                          :class="$store.lang.current === 'en' ? 'text-white' : 'text-white/40'">English</span>
                </div>

                {{-- Store --}}
                @if(App\Models\SiteSetting::get('store_enabled', 'true') === 'true')
                <a href="/store/login"
                   class="px-3 py-2 rounded-lg text-sm font-bold text-white/70 hover:text-white hover:bg-white/10 transition-all duration-300 flex items-center gap-1.5">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Store
                </a>
                @endif

                {{-- Intranet --}}
                @auth
                    <a href="/intranet"
                       class="px-3 py-2 rounded-lg text-sm font-bold text-white/70 hover:text-white hover:bg-white/10 transition-all duration-300 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Intranet
                    </a>
                @endauth
            </div>

            {{-- Mobile: Lang + Menu Button --}}
            <div class="xl:hidden flex items-center gap-2">
                {{-- Mobile Language Toggle Switch --}}
                <div class="flex items-center gap-1.5" id="lang-toggle-mobile">
                    <span class="text-[10px] font-bold tracking-wide transition-colors duration-300"
                          :class="$store.lang.current === 'es' ? 'text-white' : 'text-white/40'">Español</span>
                    <button @click="$store.lang.toggle()"
                            class="relative w-[44px] h-[24px] rounded-full transition-all duration-400 ease-in-out focus:outline-none"
                            :class="$store.lang.current === 'en' ? 'bg-gradient-to-r from-red-600 to-red-700 shadow-lg shadow-red-600/30' : 'bg-gradient-to-r from-neutral-800 to-neutral-900 shadow-lg shadow-black/40 border border-white/10'">
                        <span class="absolute top-[3px] left-[3px] w-[18px] h-[18px] bg-white rounded-full shadow-md transition-all duration-400 ease-in-out"
                              :style="$store.lang.current === 'en' ? 'transform: translateX(20px)' : 'transform: translateX(0)'"></span>
                    </button>
                    <span class="text-[10px] font-bold tracking-wide transition-colors duration-300"
                          :class="$store.lang.current === 'en' ? 'text-white' : 'text-white/40'">English</span>
                </div>
                <button @click="mobileOpen = !mobileOpen"
                        class="p-2 rounded-lg text-white hover:bg-white/10 transition-colors"
                        id="mobile-menu-toggle">
                    <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="mobileOpen" x-cloak class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 -translate-y-4"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 -translate-y-4"
         class="xl:hidden bg-black/95 backdrop-blur-xl border-t border-white/10"
         x-cloak id="mobile-menu">
        <div class="max-w-7xl mx-auto px-4 py-6 space-y-1">
            <a href="/" class="block px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm" x-text="$store.lang.current === 'en' ? 'Home' : 'Inicio'"></a>
            {{-- About Us Mobile Dropdown --}}
            <div x-data="{ subOpen: false }">
                <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm">
                    <span x-text="$store.lang.current === 'en' ? 'About Us' : 'Sobre Nosotros'"></span>
                    <svg class="w-4 h-4 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="subOpen" x-transition class="pl-6 space-y-1 mt-1">
                    <a :href="isHome ? '#about' : '/#about'" @click="mobileOpen = false; if(isHome) $dispatch('set-about-tab', { tab: 'who' })" class="block px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors font-semibold text-sm" x-text="$store.lang.current === 'en' ? 'Who We Are' : 'Quiénes Somos'"></a>
                    <a :href="isHome ? '#about' : '/#about'" @click="mobileOpen = false; if(isHome) $dispatch('set-about-tab', { tab: 'vision' })" class="block px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors font-semibold text-sm" x-text="$store.lang.current === 'en' ? 'Vision' : 'Visión'"></a>
                    <a :href="isHome ? '#about' : '/#about'" @click="mobileOpen = false; if(isHome) $dispatch('set-about-tab', { tab: 'mission' })" class="block px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors font-semibold text-sm" x-text="$store.lang.current === 'en' ? 'Mission' : 'Misión'"></a>
                </div>
            </div>
            <a :href="isHome ? '#services' : '/#services'" @click="mobileOpen = false; if(isHome) { $event.preventDefault(); $store.sections.show('services') }" class="block px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm" x-text="$store.lang.current === 'en' ? 'Services' : 'Servicios'"></a>

            {{-- Opportunities --}}
            <div x-data="{ subOpen: false }">
                <button @click="subOpen = !subOpen" class="flex items-center justify-between w-full px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm">
                    <span x-text="$store.lang.current === 'en' ? 'Opportunities' : 'Oportunidades'"></span>
                    <svg class="w-4 h-4 transition-transform" :class="subOpen ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="subOpen" x-transition class="pl-6 space-y-1 mt-1">
                    <a :href="isHome ? '#opportunities' : '/#opportunities'" @click="mobileOpen = false; if(isHome) { $event.preventDefault(); $store.sections.show('opportunities') }" class="block px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors font-semibold text-sm" x-text="$store.lang.current === 'en' ? 'Positions' : 'Posiciones'"></a>
                    <a href="/careers" @click="mobileOpen = false" class="block px-4 py-2.5 text-white/80 hover:text-white hover:bg-white/10 rounded-lg transition-colors font-semibold text-sm" x-text="$store.lang.current === 'en' ? 'Apply' : 'Postular'"></a>
                </div>
            </div>

            <a :href="isHome ? '#events' : '/#events'" @click="mobileOpen = false; if(isHome) { $event.preventDefault(); $store.sections.show('events') }" class="block px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm" x-text="$store.lang.current === 'en' ? 'Relevant Events' : 'Eventos Relevantes'"></a>
            <a :href="isHome ? '#testimonials' : '/#testimonials'" @click="mobileOpen = false; if(isHome) { $event.preventDefault(); $store.sections.show('testimonials') }" class="block px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm" x-text="$store.lang.current === 'en' ? 'Testimonials' : 'Testimonios'"></a>
            <a :href="isHome ? '#clients' : '/#clients'" @click="mobileOpen = false; if(isHome) { $event.preventDefault(); $store.sections.show('clients') }" class="block px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm" x-text="$store.lang.current === 'en' ? 'Clients' : 'Clientes'"></a>
            <a :href="isHome ? '#contact' : '/#contact'" @click="mobileOpen = false; if(isHome) { $event.preventDefault(); $store.sections.show('contact') }" class="block px-4 py-3 text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm" x-text="$store.lang.current === 'en' ? 'Contact Us' : 'Contáctenos'"></a>

            <div class="pt-4 border-t border-white/10 space-y-1">
                @if(App\Models\SiteSetting::get('store_enabled', 'true') === 'true')
                <a href="/store/login" class="flex items-center gap-2 px-4 py-3 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Store
                </a>
                @endif
                @auth
                    <a href="/intranet" class="flex items-center gap-2 px-4 py-3 text-white/70 hover:text-white hover:bg-white/10 rounded-lg transition-colors font-bold text-sm">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Intranet
                    </a>
                @endauth
            </div>
        </div>
    </div>
</header>
{{-- Spacer: only on non-homepage pages where navbar is solid --}}
@if(!request()->is('/'))
<div class="h-20"></div>
@endif
