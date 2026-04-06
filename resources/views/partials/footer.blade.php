{{-- Constellis Footer — Blue & White --}}
<footer class="relative bg-slate-900 text-white overflow-hidden" id="site-footer">
    {{-- Decorative background --}}
    <div class="absolute inset-0">
        <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-blue-600/5 rounded-full blur-[120px]"></div>
        <div class="absolute bottom-0 right-1/4 w-[400px] h-[400px] bg-sky-500/5 rounded-full blur-[100px]"></div>
    </div>

    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Main Footer --}}
        <div class="py-20 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-12 gap-12">
            {{-- Brand --}}
            <div class="lg:col-span-4">
                <a href="{{ url('/') }}" class="flex items-center gap-3 mb-6">
                    <svg class="w-9 h-9 text-blue-400" viewBox="0 0 40 40" fill="none">
                        <path d="M20 2L36 11V29L20 38L4 29V11L20 2Z" stroke="currentColor" stroke-width="1.5" fill="none"/>
                        <path d="M20 8L30 14V26L20 32L10 26V14L20 8Z" fill="currentColor" fill-opacity="0.15" stroke="currentColor" stroke-width="1"/>
                        <circle cx="20" cy="20" r="4" fill="currentColor"/>
                    </svg>
                    <span class="font-display text-xl font-bold tracking-tight">
                        <span class="text-blue-400">C</span>ONSTELLIS
                    </span>
                </a>
                <p class="text-slate-400 text-sm leading-relaxed mb-8 max-w-sm">
                    Providing end-to-end risk management and comprehensive security solutions to safeguard people and infrastructure globally.
                </p>
                <div class="flex items-center gap-3">
                    @foreach([
                        ['LinkedIn', 'https://www.linkedin.com/company/constellis', 'M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452z'],
                        ['X', 'https://twitter.com/constellis', 'M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z'],
                        ['Facebook', 'https://www.facebook.com/constellis', 'M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z'],
                    ] as $social)
                        <a href="{{ $social[1] }}" target="_blank" rel="noopener" class="w-10 h-10 rounded-xl bg-white/5 border border-white/10 flex items-center justify-center text-slate-400 hover:text-white hover:bg-blue-600 hover:border-blue-600 transition-all duration-300" aria-label="{{ $social[0] }}">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="{{ $social[2] }}"/></svg>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Links --}}
            @php
                $footerSections = [
                    ['title' => 'Who We Are', 'links' => [
                        ['Executive Leadership', '/who-we-are/leadership'],
                        ['Mission & Vision', '/mission-vision'],
                        ['Experience', '/experience'],
                        ['Partners', '/partners'],
                        ['Constellis History', '/who-we-are/constellis-history'],
                    ]],
                    ['title' => 'Operations', 'links' => [
                        ['Projects', '/projects'],
                        ['Careers', '/careers'],
                        ['Employee Store', '/store/login'],
                        ['Intranet', '/login?redirect=/intranet'],
                        ['LEXSO™', '/lexso'],
                    ]],
                    ['title' => 'Resources', 'links' => [
                        ['News', '/news'],
                        ['Contact Us', '/contact'],
                        ['Privacy Policy', '/privacy-policy'],
                        ['Terms of Use', '/terms-of-use'],
                    ]],
                ];
            @endphp

            @foreach($footerSections as $section)
                <div class="lg:col-span-2">
                    <h4 class="font-display font-semibold text-sm uppercase tracking-wider text-white mb-6">{{ $section['title'] }}</h4>
                    <ul class="space-y-3">
                        @foreach($section['links'] as $link)
                            <li>
                                <a href="{{ str_starts_with($link[1], 'http') ? $link[1] : url($link[1]) }}"
                                   @if(str_starts_with($link[1], 'http')) target="_blank" rel="noopener" @endif
                                   class="text-slate-400 hover:text-blue-400 text-sm transition-colors duration-200">
                                    {{ $link[0] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            {{-- Contact --}}
            <div class="lg:col-span-2">
                <h4 class="font-display font-semibold text-sm uppercase tracking-wider text-white mb-6">Contact</h4>
                <ul class="space-y-4">
                    <li>
                        <a href="tel:18663491506" class="flex items-center gap-3 text-slate-400 hover:text-blue-400 transition-colors text-sm">
                            <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            +1 866 349 1506
                        </a>
                    </li>
                    <li>
                        <a href="tel:17036735000" class="flex items-center gap-3 text-slate-400 hover:text-blue-400 transition-colors text-sm">
                            <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 3l-6 6m0 0V4m0 5h5M5 3a2 2 0 00-2 2v1c0 8.284 6.716 15 15 15h1a2 2 0 002-2v-3.28a1 1 0 00-.684-.948l-4.493-1.498a1 1 0 00-1.21.502l-1.13 2.257a11.042 11.042 0 01-5.516-5.517l2.257-1.128a1 1 0 00.502-1.21L9.228 3.683A1 1 0 008.279 3H5z"/></svg>
                            +1 703 673 5000
                        </a>
                    </li>
                    <li>
                        <a href="mailto:info@constellis.com" class="flex items-center gap-3 text-slate-400 hover:text-blue-400 transition-colors text-sm">
                            <svg class="w-4 h-4 text-blue-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            info@constellis.com
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/10 py-8 flex flex-col md:flex-row items-center justify-between gap-4">
            <p class="text-slate-500 text-xs">&copy; {{ date('Y') }} Constellis. All rights reserved.</p>
            <div class="flex items-center gap-6 text-xs text-slate-500">
                <a href="{{ url('/privacy-policy') }}" class="hover:text-blue-400 transition-colors">Privacy Policy</a>
                <a href="{{ url('/terms-of-use') }}" class="hover:text-blue-400 transition-colors">Terms of Use</a>
                <span>E-Verify Employer</span>
            </div>
        </div>
    </div>
</footer>
