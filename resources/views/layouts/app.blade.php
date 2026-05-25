<!DOCTYPE html>
<html lang="en" class="scroll-smooth" x-data x-bind:lang="$store.lang.current">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'NSG — Global Security & Defense')</title>
    <meta name="description" content="@yield('meta_description', 'A network of over 72,000 professionals working to safeguard freedom, democracy, and the rule of law worldwide.')">

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/NSG.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/NSG.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@600;700;800;900&family=Raleway:wght@400;500;600;700;800;900&family=Open+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('lang', {
                current: localStorage.getItem('nsg_lang') || 'en',
                toggle() {
                    this.current = this.current === 'en' ? 'es' : 'en';
                    localStorage.setItem('nsg_lang', this.current);
                    document.documentElement.lang = this.current;
                }
            });
            Alpine.store('sections', {
                active: null,
                show(section) {
                    this.active = section;
                    setTimeout(() => {
                        const el = document.getElementById(section);
                        if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }, 100);
                }
            });
        });
    </script>
</head>
<body class="min-h-screen flex flex-col antialiased">

    @include('partials.header')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('partials.footer')

    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // ── Enhanced Scroll Animations ──
            const animateOnScroll = () => {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (!entry.isIntersecting) return;

                        const el = entry.target;
                        const animType = el.dataset.animate || 'fade-up';
                        const delay = parseInt(el.dataset.delay || '0');

                        setTimeout(() => {
                            el.style.opacity = '1';
                            el.style.transform = 'none';
                            el.style.filter = 'blur(0)';

                            // Stagger children (for grids/lists)
                            if (el.dataset.stagger !== undefined) {
                                const children = el.children;
                                Array.from(children).forEach((child, i) => {
                                    child.style.opacity = '0';
                                    child.style.transform = 'translateY(30px)';
                                    child.style.transition = `all 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) ${i * 80}ms`;
                                    requestAnimationFrame(() => {
                                        requestAnimationFrame(() => {
                                            child.style.opacity = '1';
                                            child.style.transform = 'translateY(0)';
                                        });
                                    });
                                });
                            }
                        }, delay);

                        observer.unobserve(el);
                    });
                }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });

                document.querySelectorAll('[data-animate]').forEach(el => {
                    const animType = el.dataset.animate || 'fade-up';
                    el.style.opacity = '0';
                    el.style.transition = 'all 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94)';

                    switch (animType) {
                        case 'fade-up':
                            el.style.transform = 'translateY(50px)';
                            break;
                        case 'fade-down':
                            el.style.transform = 'translateY(-50px)';
                            break;
                        case 'fade-left':
                            el.style.transform = 'translateX(-60px)';
                            break;
                        case 'fade-right':
                            el.style.transform = 'translateX(60px)';
                            break;
                        case 'scale':
                            el.style.transform = 'scale(0.85)';
                            el.style.filter = 'blur(4px)';
                            break;
                        case 'zoom':
                            el.style.transform = 'scale(0.9)';
                            break;
                        default:
                            el.style.transform = 'translateY(40px)';
                    }

                    observer.observe(el);
                });
            };

            animateOnScroll();

            // ── Parallax sections on scroll ──
            let ticking = false;
            window.addEventListener('scroll', () => {
                if (!ticking) {
                    requestAnimationFrame(() => {
                        const scrollY = window.scrollY;
                        document.querySelectorAll('[data-parallax]').forEach(el => {
                            const speed = parseFloat(el.dataset.parallax || '0.3');
                            const rect = el.getBoundingClientRect();
                            const offset = (rect.top + scrollY - window.innerHeight / 2) * speed;
                            el.style.transform = `translateY(${-offset * 0.1}px)`;
                        });
                        ticking = false;
                    });
                    ticking = true;
                }
            });

            // ── Counter animation ──
            document.querySelectorAll('[data-count]').forEach(counter => {
                const target = parseInt(counter.dataset.count);
                const suffix = counter.dataset.suffix || '';
                const prefix = counter.dataset.prefix || '';
                const duration = 2000;
                const step = target / (duration / 16);
                let current = 0;

                const counterObs = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const interval = setInterval(() => {
                                current += step;
                                if (current >= target) { current = target; clearInterval(interval); }
                                counter.textContent = prefix + Math.floor(current).toLocaleString() + suffix;
                            }, 16);
                            counterObs.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                counterObs.observe(counter);
            });
        });
    </script>
</body>
</html>
