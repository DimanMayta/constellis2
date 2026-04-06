<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Constellis - Securing the Future')</title>
    <meta name="description" content="@yield('meta_description', 'Constellis provides end-to-end risk management and comprehensive security solutions to safeguard people and infrastructure globally.')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
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
            // Scroll animation observer
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('animate-fade-in-up');
                        entry.target.style.opacity = '1';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -60px 0px' });

            document.querySelectorAll('[data-animate]').forEach(el => {
                el.style.opacity = '0';
                observer.observe(el);
            });

            // Counter animation
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

            // Parallax on mouse move (subtle tilt on hero)
            const hero = document.getElementById('hero-visual');
            if (hero) {
                document.addEventListener('mousemove', (e) => {
                    const x = (e.clientX / window.innerWidth - 0.5) * 10;
                    const y = (e.clientY / window.innerHeight - 0.5) * 10;
                    hero.style.transform = `perspective(1000px) rotateY(${x}deg) rotateX(${-y}deg)`;
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
