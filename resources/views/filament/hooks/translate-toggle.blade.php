{{-- Google Translate Button --}}
<div x-data="{ translating: false }" class="flex items-center">
    <button
        x-on:click="
            translating = !translating;
            if (translating) {
                if (!document.getElementById('google-translate-script')) {
                    let s = document.createElement('script');
                    s.id = 'google-translate-script';
                    s.src = '//translate.google.com/translate_a/element.js?cb=googleTranslateInit';
                    document.head.appendChild(s);
                    window.googleTranslateInit = function() {
                        new google.translate.TranslateElement({
                            pageLanguage: 'en',
                            includedLanguages: 'es,en',
                            autoDisplay: false,
                            layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
                        }, 'google_translate_element');
                    };
                }
                $nextTick(() => {
                    setTimeout(() => {
                        let frame = document.querySelector('.goog-te-menu-frame');
                        if (frame) {
                            let items = frame.contentDocument.querySelectorAll('.goog-te-menu2-item span.text');
                            items.forEach(item => { if (item.textContent === 'Spanish' || item.textContent === 'español') item.click(); });
                        } else {
                            let combo = document.querySelector('.goog-te-combo');
                            if (combo) { combo.value = 'es'; combo.dispatchEvent(new Event('change')); }
                        }
                    }, 1000);
                });
            } else {
                let frame = document.querySelector('.goog-te-banner-frame');
                if (frame) {
                    let btn = frame.contentDocument.querySelector('.goog-close-link');
                    if (btn) btn.click();
                }
                let combo = document.querySelector('.goog-te-combo');
                if (combo) { combo.value = 'en'; combo.dispatchEvent(new Event('change')); }
                document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;';
                document.cookie = 'googtrans=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/; domain=.' + location.hostname;
            }
        "
        class="relative inline-flex items-center gap-2 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200"
        :class="translating
            ? 'bg-amber-500/20 text-amber-400 border border-amber-500/30'
            : 'text-gray-400 hover:text-gray-200 hover:bg-white/5'"
        title="Traducir a Español / Translate to English"
    >
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="m10.5 21 5.25-11.25L21 21m-9-3h7.5M3 5.621a48.474 48.474 0 0 1 6-.371m0 0c1.12 0 2.233.038 3.334.114M9 5.25V3m3.334 2.364C11.176 10.658 7.69 15.08 3 17.502m9.334-12.138c.896.061 1.785.147 2.666.257m-4.589 8.495a18.023 18.023 0 0 1-3.827-5.802" />
        </svg>
        <span x-text="translating ? 'ES' : 'EN'" class="text-xs font-bold"></span>
    </button>
</div>

{{-- Hidden Google Translate container --}}
<div id="google_translate_element" style="position:absolute;left:-9999px;top:-9999px;"></div>

<style>
    /* Hide Google Translate bar and artifacts */
    .goog-te-banner-frame { display: none !important; }
    body { top: 0 !important; }
    .goog-tooltip, .goog-tooltip:hover { display: none !important; }
    .goog-text-highlight { background-color: transparent !important; box-shadow: none !important; }
    .skiptranslate { display: none !important; }
    #google_translate_element { display: none !important; }
</style>
