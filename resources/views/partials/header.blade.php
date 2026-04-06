{{-- Constellis Header — New Navigation Structure --}}
<header x-data="{ mobileOpen: false, scrolled: false }"
        x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
        :class="scrolled ? 'bg-white/90 backdrop-blur-2xl shadow-lg shadow-slate-900/5 border-b border-slate-100' : 'bg-white/0'"
        class="fixed top-0 left-0 right-0 z-50 transition-all duration-500"
        id="main-header">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            {{-- Logo --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3 group" id="logo-link">
                <div class="relative">
                    <svg class="w-10 h-10 text-blue-600 transition-all duration-300 group-hover:text-blue-700" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 2L36 11V29L20 38L4 29V11L20 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" fill="currentColor" fill-opacity="0.12" stroke="currentColor" stroke-width="1"/>
                        <circle cx="20" cy="20" r="4" fill="currentColor"/>
                    </svg>
                </div>
                <span class="font-display text-2xl font-bold tracking-tight" :class="scrolled ? 'text-slate-900' : 'text-white'">
                    <span class="text-blue-600">C</span><span :class="scrolled ? 'text-slate-900' : 'text-white'">ONSTELLIS</span>
                </span>
            </a>

            {{-- Desktop Navigation --}}
            <nav class="hidden lg:flex items-center gap-0.5" id="desktop-nav">
                {{-- Who We Are (Mega Menu) --}}
                <div class="nav-item relative" id="nav-who-we-are">
                    <a href="{{ url('/who-we-are/leadership') }}"
                       class="btn-ghost flex items-center gap-1.5"
                       :class="scrolled ? 'text-slate-600 hover:text-blue-700 hover:bg-blue-50' : 'text-white/80 hover:text-white hover:bg-white/10'">
                        Who We Are
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="mega-menu pt-4" style="left: -100px; min-width: 560px;">
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/50 p-6">
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $aboutLinks = [
                                        ['Executive Leadership', '/who-we-are/leadership', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', 'Meet our leadership team'],
                                        ['Mission & Vision', '/mission-vision', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Our purpose and strategic goals'],
                                        ['Experience', '/experience', 'M13 10V3L4 14h7v7l9-11h-7z', 'Team expertise & global reach'],
                                        ['Partners', '/partners', 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'Strategic allies'],
                                        ['Constellis History', '/who-we-are/constellis-history', 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'Our story and legacy'],
                                        ['Divisions', '/who-we-are/divisions', 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5', 'Operating brands'],
                                    ];
                                @endphp
                                @foreach($aboutLinks as $link)
                                    <a href="{{ url($link[1]) }}" class="flex items-center gap-4 p-3 rounded-xl hover:bg-blue-50 transition-colors group/link">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover/link:bg-blue-600 group-hover/link:text-white transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $link[2] }}"/></svg>
                                        </div>
                                        <div>
                                            <span class="text-slate-800 font-semibold text-sm group-hover/link:text-blue-700 transition-colors">{{ $link[0] }}</span>
                                            <p class="text-slate-400 text-xs mt-0.5">{{ $link[3] }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- What We Do (Mega Menu) --}}
                <div class="nav-item relative" id="nav-what-we-do">
                    <a href="{{ url('/services') }}"
                       class="btn-ghost flex items-center gap-1.5"
                       :class="scrolled ? 'text-slate-600 hover:text-blue-700 hover:bg-blue-50' : 'text-white/80 hover:text-white hover:bg-white/10'">
                        What We Do
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </a>
                    <div class="mega-menu pt-4" style="left: -80px; min-width: 480px;">
                        <div class="bg-white rounded-2xl border border-slate-100 shadow-xl shadow-slate-200/50 p-6">
                            <div class="grid grid-cols-2 gap-2">
                                @php
                                    $serviceLinks = [
                                        ['Protective Security', '/services', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z', 'Risk & security solutions'],
                                        ['Global Stability Operations', '/services', 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064', 'Worldwide deployment support'],
                                        ['Unexploded Ordnance', '/services', 'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z', 'Mine clearance & UXO removal'],
                                        ['Operational Support', '/services', 'M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z', 'Logistics & life support'],
                                        ['Training & Advisory', '/training', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'Professional development'],
                                        ['LEXSO™', '/lexso', 'M13 10V3L4 14h7v7l9-11h-7z', 'Law enforcement exchange'],
                                    ];
                                @endphp
                                @foreach($serviceLinks as $link)
                                    <a href="{{ url($link[1]) }}" class="flex items-center gap-4 p-3 rounded-xl hover:bg-blue-50 transition-colors group/link">
                                        <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 group-hover/link:bg-blue-600 group-hover/link:text-white transition-all duration-300">
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $link[2] }}"/></svg>
                                        </div>
                                        <div>
                                            <span class="text-slate-800 font-semibold text-sm group-hover/link:text-blue-700 transition-colors">{{ $link[0] }}</span>
                                            <p class="text-slate-400 text-xs mt-0.5">{{ $link[3] }}</p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Simple Links --}}
                @foreach([
                    ['Who We Serve', '/who-we-serve'],
                    ['Careers', '/careers'],
                    ['LEXSO™', '/lexso'],
                    ['Training', '/training'],
                    ['Contracts', '/contracts'],
                    ['News', '/news'],
                ] as $link)
                    <a href="{{ url($link[1]) }}"
                       class="btn-ghost"
                       :class="scrolled ? 'text-slate-600 hover:text-blue-700 hover:bg-blue-50' : 'text-white/80 hover:text-white hover:bg-white/10'">
                        {{ $link[0] }}
                    </a>
                @endforeach

                {{-- Store (locked) --}}
                <a href="{{ url('/store/login') }}"
                   class="btn-ghost flex items-center gap-1.5"
                   :class="scrolled ? 'text-slate-600 hover:text-blue-700 hover:bg-blue-50' : 'text-white/80 hover:text-white hover:bg-white/10'">
                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Store
                </a>
            </nav>

            {{-- Right Side Actions --}}
            <div class="hidden lg:flex items-center gap-3">
                @auth
                    <a href="{{ url('/intranet') }}"
                       class="btn-ghost flex items-center gap-1.5"
                       :class="scrolled ? 'text-slate-600 hover:text-blue-700 hover:bg-blue-50' : 'text-white/80 hover:text-white hover:bg-white/10'">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Intranet
                    </a>
                @endauth
                <a href="{{ url('/contact') }}"
                   :class="scrolled ? 'bg-blue-600 text-white shadow-blue-600/25 hover:bg-blue-700' : 'bg-white text-blue-700 shadow-white/20 hover:bg-blue-50'"
                   class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl font-semibold text-sm shadow-lg transition-all duration-300 hover:-translate-y-0.5"
                   id="nav-contact">
                    Contact Us
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>

            {{-- Mobile Menu Button --}}
            <button @click="mobileOpen = !mobileOpen"
                    class="lg:hidden p-2 rounded-lg transition-colors"
                    :class="scrolled ? 'text-slate-600 hover:bg-slate-100' : 'text-white hover:bg-white/10'"
                    id="mobile-menu-toggle">
                <svg x-show="!mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                <svg x-show="mobileOpen" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
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
         class="lg:hidden bg-white border-t border-slate-100 shadow-lg"
         id="mobile-menu">
        <div class="max-w-7xl mx-auto px-4 py-6 space-y-1">
            {{-- Who We Are Section --}}
            <p class="px-4 pt-2 pb-1 text-xs font-bold text-slate-400 uppercase tracking-wider">Who We Are</p>
            @foreach([
                ['Leadership', '/who-we-are/leadership'],
                ['Mission & Vision', '/mission-vision'],
                ['Experience', '/experience'],
                ['Divisions', '/who-we-are/divisions'],
                ['Partners', '/partners'],
                ['History', '/who-we-are/constellis-history'],
            ] as $link)
                <a href="{{ url($link[1]) }}" class="block px-4 py-2.5 text-slate-700 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors font-medium text-sm">{{ $link[0] }}</a>
            @endforeach

            <div class="border-t border-slate-100 my-2"></div>

            {{-- What We Do Section --}}
            <p class="px-4 pt-2 pb-1 text-xs font-bold text-slate-400 uppercase tracking-wider">What We Do</p>
            @foreach([
                ['Services', '/services'],
                ['LEXSO™', '/lexso'],
                ['Training', '/training'],
            ] as $link)
                <a href="{{ url($link[1]) }}" class="block px-4 py-2.5 text-slate-700 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors font-medium text-sm">{{ $link[0] }}</a>
            @endforeach

            <div class="border-t border-slate-100 my-2"></div>

            {{-- Main Links --}}
            @foreach([
                ['Who We Serve', '/who-we-serve'],
                ['Careers', '/careers'],
                ['Contracts', '/contracts'],
                ['News', '/news'],
                ['Contact', '/contact'],
            ] as $link)
                <a href="{{ url($link[1]) }}" class="block px-4 py-3 text-slate-700 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors font-medium">{{ $link[0] }}</a>
            @endforeach

            <div class="pt-4 border-t border-slate-100 space-y-2">
                <a href="{{ url('/store/login') }}" class="flex items-center gap-2 px-4 py-3 text-slate-700 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors font-medium">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Employee Store
                </a>
                @auth
                    <a href="{{ url('/intranet') }}" class="flex items-center gap-2 px-4 py-3 text-slate-700 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors font-medium">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Intranet
                    </a>
                @endauth
                <a href="{{ url('/contact') }}" class="btn-primary w-full">Contact Us</a>
            </div>
        </div>
    </div>
</header>
{{-- Spacer for fixed header --}}
<div class="h-20"></div>
