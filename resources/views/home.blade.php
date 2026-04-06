@extends('layouts.app')

@section('title', 'Constellis — Securing the Future')
@section('meta_description', 'Our highly trained, impact-driven professionals navigate our customers through diverse environments and guide them to success.')

@section('content')

{{-- ============================================================
     HERO SECTION — Blue gradient with wireframe globe
     ============================================================ --}}
<section class="relative min-h-[92vh] flex items-center overflow-hidden -mt-20 pt-20" id="hero">
    {{-- Background --}}
    <div class="absolute inset-0 bg-hero-blue"></div>
    <div class="absolute inset-0 line-grid opacity-40"></div>

    {{-- Wireframe Globe Canvas --}}
    <canvas id="globe-canvas" class="absolute inset-0 w-full h-full pointer-events-none" style="z-index:5"></canvas>

    {{-- Morphing blobs --}}
    <div class="blob w-[500px] h-[500px] bg-sky-400/10 top-10 -right-20 animate-morph"></div>
    <div class="blob w-[400px] h-[400px] bg-blue-300/10 -bottom-20 left-10 animate-morph" style="animation-delay:-4s"></div>

    {{-- Floating geometric shapes --}}
    <div class="floating-shape top-1/4 right-[15%] w-20 h-20 border-2 border-white/10 rounded-2xl rotate-12"></div>
    <div class="floating-shape bottom-1/3 right-[25%] w-12 h-12 border border-white/10 rounded-full" style="animation-delay:-3s"></div>
    <div class="floating-shape top-[40%] left-[8%] w-16 h-16 border-2 border-white/8 rotate-45" style="animation-delay:-5s"></div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div>
                {{-- Badge --}}
                <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 text-white text-xs font-semibold tracking-wider uppercase mb-8 animate-fade-in">
                    <span class="w-2 h-2 rounded-full bg-blue-300 animate-pulse"></span>
                    Global Security Solutions
                </div>

                <h1 class="text-5xl md:text-6xl lg:text-7xl font-display font-bold text-white leading-[1.08] mb-8 animate-fade-in-up">
                    Secure<br>
                    <span class="gradient-text-white">Success</span>
                </h1>

                <p class="text-xl text-blue-100/90 leading-relaxed mb-12 max-w-lg animate-fade-in-up delay-200">
                    Our highly trained, impact-driven professionals navigate our customers through diverse environments and guide them to success.
                </p>

                <div class="flex flex-wrap gap-4 animate-fade-in-up delay-400">
                    <a href="{{ url('/what-we-do') }}" class="btn-white">
                        Explore Our Services
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                    <a href="{{ url('/contact') }}" class="btn-outline-white">
                        Get In Touch
                    </a>
                </div>
            </div>

            {{-- Hero visual with cards --}}
            <div class="relative hidden lg:block animate-fade-in-right delay-300" id="hero-visual">
                <div class="relative">
                    {{-- Main image card --}}
                    <div class="relative rounded-3xl overflow-hidden shadow-2xl shadow-blue-900/30 img-hover-zoom animate-ken-burns" style="animation-duration:25s">
                        <div class="img-placeholder aspect-[4/3]">
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <div class="text-center">
                                    <svg class="w-20 h-20 text-white/30 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                    <p class="text-white/40 font-display font-semibold text-sm tracking-wider uppercase">Security Operations</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Floating stat card --}}
                    <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-5 animate-float z-20">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-900 font-display font-bold text-xl">35+</p>
                                <p class="text-slate-400 text-xs">Countries Served</p>
                            </div>
                        </div>
                    </div>

                    {{-- Floating badge --}}
                    <div class="absolute -top-4 -right-4 bg-white rounded-2xl shadow-xl shadow-slate-200/50 p-4 animate-float z-20" style="animation-delay:-2s">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-green-50 flex items-center justify-center text-green-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <div>
                                <p class="text-slate-900 font-semibold text-sm">ISO Certified</p>
                                <p class="text-slate-400 text-xs">9001 • 14001 • 45001</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Wave bottom --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full"><path d="M0 120V60C240 20 480 0 720 20C960 40 1200 60 1440 40V120H0Z" fill="white"/></svg>
    </div>
</section>

@push('scripts')
<script>
(function() {
    const canvas = document.getElementById('globe-canvas');
    if (!canvas) return;
    const ctx = canvas.getContext('2d');
    let w, h;

    // ── Config ──
    const SPHERE_DOTS      = 2500;
    const DOT_BASE_SIZE    = 1.1;
    const AUTO_ROTATE      = 0.0012;
    const CONNECT_DIST     = 28;        // max px distance to draw connection lines
    const CONNECT_ALPHA    = 0.06;      // connection line opacity
    const ORBIT_PARTICLES  = 35;        // floating particles around the sphere
    const MOUSE_RADIUS     = 160;       // px — area of mouse influence
    const MOUSE_STRENGTH   = 55;        // push force
    const BREATHE_SPEED    = 0.0008;    // subtle pulsing
    const BREATHE_AMP      = 0.012;     // how much it breathes (fraction of radius)

    // ── State ──
    let rotY = 0, rotX = 0.32;
    let mouseX = -9999, mouseY = -9999, mouseActive = false;
    let time = 0;

    // ── Fibonacci sphere points ──
    const pts = [];
    const ga = Math.PI * (3 - Math.sqrt(5));
    for (let i = 0; i < SPHERE_DOTS; i++) {
        const yy = 1 - (i / (SPHERE_DOTS - 1)) * 2;
        const rr = Math.sqrt(1 - yy * yy);
        const th = ga * i;
        pts.push({ x: Math.cos(th) * rr, y: yy, z: Math.sin(th) * rr });
    }

    // ── Orbiting particles (random positions on a slightly larger shell) ──
    const orbitPts = [];
    for (let i = 0; i < ORBIT_PARTICLES; i++) {
        const phi = Math.acos(2 * Math.random() - 1);
        const theta = Math.random() * Math.PI * 2;
        const dist = 1.12 + Math.random() * 0.35; // 1.12–1.47 × sphere radius
        orbitPts.push({
            x: Math.sin(phi) * Math.cos(theta) * dist,
            y: Math.cos(phi) * dist,
            z: Math.sin(phi) * Math.sin(theta) * dist,
            speed: (0.3 + Math.random() * 0.7) * (Math.random() > 0.5 ? 1 : -1),
            size: 0.8 + Math.random() * 1.5,
            alpha: 0.15 + Math.random() * 0.35,
            trail: Math.random() * 0.4 + 0.1,
        });
    }

    function resize() {
        w = canvas.width = canvas.offsetWidth;
        h = canvas.height = canvas.offsetHeight;
    }

    function draw() {
        ctx.clearRect(0, 0, w, h);
        time++;

        rotY += AUTO_ROTATE;
        const breathe = 1 + Math.sin(time * BREATHE_SPEED * 60) * BREATHE_AMP;

        const cosY = Math.cos(rotY), sinY = Math.sin(rotY);
        const cosX = Math.cos(rotX), sinX = Math.sin(rotX);

        // Globe sizing — large & dramatic, positioned right
        const radius = Math.min(w, h) * 0.48 * breathe;
        const cx = w * 0.72;
        const cy = h * 0.45;

        // ── Project sphere dots ──
        const projected = [];
        for (const p of pts) {
            let x = p.x * cosY - p.z * sinY;
            let z = p.x * sinY + p.z * cosY;
            let y = p.y;
            const y2 = y * cosX - z * sinX;
            const z2 = y * sinX + z * cosX;
            y = y2; z = z2;

            const depth = (z + 1) / 2;
            let sx = cx + x * radius;
            let sy = cy + y * radius;
            let distorted = false;

            // Mouse distortion
            if (mouseActive) {
                const dx = sx - mouseX, dy = sy - mouseY;
                const dist = Math.sqrt(dx * dx + dy * dy);
                if (dist < MOUSE_RADIUS && dist > 0) {
                    const force = 1 - dist / MOUSE_RADIUS;
                    const eased = force * force * force;
                    sx += (dx / dist) * eased * MOUSE_STRENGTH * (0.4 + depth * 0.6);
                    sy += (dy / dist) * eased * MOUSE_STRENGTH * (0.4 + depth * 0.6);
                    if (force > 0.15) distorted = true;
                }
            }

            projected.push({ sx, sy, depth, distorted });
        }

        // ── Draw connection lines between nearby dots ──
        ctx.lineWidth = 0.5;
        const step = 3; // check every 3rd dot for performance
        for (let i = 0; i < projected.length; i += step) {
            const a = projected[i];
            if (a.depth < 0.35) continue; // skip back-facing dots for connections
            for (let j = i + step; j < projected.length; j += step) {
                const b = projected[j];
                if (b.depth < 0.35) continue;
                const dx = a.sx - b.sx, dy = a.sy - b.sy;
                const d = dx * dx + dy * dy;
                if (d < CONNECT_DIST * CONNECT_DIST) {
                    const distFactor = 1 - Math.sqrt(d) / CONNECT_DIST;
                    const avgDepth = (a.depth + b.depth) / 2;
                    ctx.beginPath();
                    ctx.moveTo(a.sx, a.sy);
                    ctx.lineTo(b.sx, b.sy);
                    ctx.strokeStyle = `rgba(147, 197, 253, ${CONNECT_ALPHA * distFactor * avgDepth})`;
                    ctx.stroke();
                }
            }
        }

        // ── Draw sphere dots ──
        for (const d of projected) {
            const alpha = d.depth * 0.5 + 0.04;
            const size = DOT_BASE_SIZE * (0.35 + d.depth * 0.85);
            ctx.beginPath();
            ctx.arc(d.sx, d.sy, size, 0, Math.PI * 2);
            ctx.fillStyle = d.distorted
                ? `rgba(147, 197, 253, ${Math.min(alpha * 1.8, 0.9)})`
                : `rgba(255, 255, 255, ${alpha})`;
            ctx.fill();

            // Bloom on distorted particles
            if (d.distorted) {
                ctx.beginPath();
                ctx.arc(d.sx, d.sy, size * 3, 0, Math.PI * 2);
                ctx.fillStyle = `rgba(147, 197, 253, ${alpha * 0.15})`;
                ctx.fill();
            }
        }

        // ── Orbiting particles ──
        for (const op of orbitPts) {
            const angle = rotY * op.speed;
            const cosA = Math.cos(angle), sinA = Math.sin(angle);
            let x = op.x * cosA - op.z * sinA;
            let z = op.x * sinA + op.z * cosA;
            let y = op.y;
            const y2 = y * cosX - z * sinX;
            const z2 = y * sinX + z * cosX;
            y = y2; z = z2;

            const depth = (z + 1) / 2;
            const sx = cx + x * radius;
            const sy = cy + y * radius;

            // Particle
            ctx.beginPath();
            ctx.arc(sx, sy, op.size * (0.5 + depth * 0.5), 0, Math.PI * 2);
            ctx.fillStyle = `rgba(186, 230, 253, ${op.alpha * depth})`;
            ctx.fill();

            // Subtle trail / glow
            ctx.beginPath();
            ctx.arc(sx, sy, op.size * 3, 0, Math.PI * 2);
            ctx.fillStyle = `rgba(147, 197, 253, ${op.trail * depth * 0.08})`;
            ctx.fill();
        }

        // ── Inner core glow ──
        const coreGlow = ctx.createRadialGradient(cx, cy, 0, cx, cy, radius * 0.65);
        coreGlow.addColorStop(0, 'rgba(59, 130, 246, 0.06)');
        coreGlow.addColorStop(0.5, 'rgba(59, 130, 246, 0.03)');
        coreGlow.addColorStop(1, 'rgba(59, 130, 246, 0)');
        ctx.fillStyle = coreGlow;
        ctx.fillRect(cx - radius, cy - radius, radius * 2, radius * 2);

        // ── Outer atmospheric halo ──
        const halo = ctx.createRadialGradient(cx, cy, radius * 0.9, cx, cy, radius * 1.5);
        halo.addColorStop(0, 'rgba(96, 165, 250, 0.05)');
        halo.addColorStop(0.4, 'rgba(59, 130, 246, 0.03)');
        halo.addColorStop(1, 'rgba(59, 130, 246, 0)');
        ctx.fillStyle = halo;
        ctx.fillRect(cx - radius * 1.6, cy - radius * 1.6, radius * 3.2, radius * 3.2);

        // ── Mouse proximity glow ──
        if (mouseActive) {
            const mouseGlow = ctx.createRadialGradient(mouseX, mouseY, 0, mouseX, mouseY, MOUSE_RADIUS * 1.2);
            mouseGlow.addColorStop(0, 'rgba(147, 197, 253, 0.08)');
            mouseGlow.addColorStop(0.5, 'rgba(96, 165, 250, 0.03)');
            mouseGlow.addColorStop(1, 'rgba(59, 130, 246, 0)');
            ctx.fillStyle = mouseGlow;
            ctx.fillRect(mouseX - MOUSE_RADIUS * 1.5, mouseY - MOUSE_RADIUS * 1.5,
                         MOUSE_RADIUS * 3, MOUSE_RADIUS * 3);
        }

        requestAnimationFrame(draw);
    }

    // ── Mouse tracking ──
    const hero = document.getElementById('hero');
    if (hero) {
        canvas.style.pointerEvents = 'auto';
        hero.addEventListener('mousemove', (e) => {
            const rect = canvas.getBoundingClientRect();
            mouseX = e.clientX - rect.left;
            mouseY = e.clientY - rect.top;
            mouseActive = true;
        });
        hero.addEventListener('mouseleave', () => {
            mouseActive = false;
        });
    }

    resize();
    draw();
    window.addEventListener('resize', resize);
})();
</script>
@endpush




{{-- ============================================================
     STATS SECTION
     ============================================================ --}}
<section class="relative py-20 bg-white" id="stats">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            @php
                $stats = [
                    ['count' => 1500, 'suffix' => 'M+', 'prefix' => '$', 'label' => 'Annual Revenue', 'color' => 'blue'],
                    ['count' => 35, 'suffix' => '+', 'prefix' => '', 'label' => 'Countries Served', 'color' => 'sky'],
                    ['count' => 20000, 'suffix' => '+', 'prefix' => '', 'label' => 'Global Workforce', 'color' => 'blue'],
                    ['count' => 20, 'suffix' => '+', 'prefix' => '', 'label' => 'Years of Excellence', 'color' => 'sky'],
                ];
            @endphp
            @foreach($stats as $stat)
                <div class="text-center" data-animate>
                    <p class="text-4xl md:text-5xl font-display font-bold gradient-text mb-2"
                       data-count="{{ $stat['count'] }}" data-suffix="{{ $stat['suffix'] }}" data-prefix="{{ $stat['prefix'] }}">
                        {{ $stat['prefix'] }}0{{ $stat['suffix'] }}
                    </p>
                    <p class="text-slate-400 text-sm font-medium tracking-wide uppercase">{{ $stat['label'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     ABOUT PREVIEW
     ============================================================ --}}
<section class="relative py-28 bg-slate-50 overflow-hidden" id="about-preview">
    <div class="absolute inset-0 bg-mesh-1"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-2 gap-20 items-center">
            {{-- Image side --}}
            <div class="relative" data-animate>
                <div class="relative z-10">
                    {{-- Main image --}}
                    <div class="rounded-3xl overflow-hidden shadow-blue-lg img-hover-zoom img-hover-shine">
                        <div class="img-placeholder aspect-[4/3]">
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <svg class="w-16 h-16 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                            </div>
                        </div>
                    </div>

                    {{-- Small overlapping image --}}
                    <div class="absolute -bottom-8 -right-8 w-48 h-48 rounded-2xl overflow-hidden shadow-xl border-4 border-white img-hover-zoom z-20">
                        <div class="img-placeholder w-full h-full" style="background: linear-gradient(135deg, #93c5fd, #3b82f6, #1d4ed8)">
                            <div class="absolute inset-0 flex items-center justify-center z-10">
                                <svg class="w-10 h-10 text-white/40" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Decorative dots --}}
                <div class="absolute -top-4 -left-4 w-24 h-24 dot-grid rounded-2xl"></div>
            </div>

            {{-- Text side --}}
            <div data-animate>
                <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">About Constellis</span>
                <h2 class="section-heading mb-8">
                    A Tradition of <span class="gradient-text">Excellence</span>
                </h2>
                <p class="text-slate-600 text-lg leading-relaxed mb-6">
                    In an ever-changing and complex world, security concerns are paramount. Enhanced security requires education, training and specialized skills.
                </p>
                <p class="text-slate-500 leading-relaxed mb-10">
                    Constellis provides end-to-end risk management and comprehensive security solutions to safeguard people and infrastructure globally. Our team of strategic problem solvers has a steadfast moral compass and unwavering dedication to the success of our customers and partners.
                </p>

                {{-- Feature list --}}
                <div class="grid grid-cols-2 gap-4 mb-10">
                    @foreach(['ISO Certified', 'Global Operations', '20+ Years', 'Expert Teams'] as $feature)
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <span class="text-slate-700 font-medium text-sm">{{ $feature }}</span>
                        </div>
                    @endforeach
                </div>

                <a href="{{ url('/who-we-are/leadership') }}" class="btn-primary">
                    Meet Our Leadership
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     SERVICES GRID
     ============================================================ --}}
<section class="relative py-28 bg-white" id="services">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16" data-animate>
            <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">What We Do</span>
            <h2 class="section-heading mb-6">
                Global Expertise, <span class="gradient-text">Local Solutions</span>
            </h2>
            <p class="section-subheading mx-auto">
                Comprehensive security, intelligence, and training solutions tailored to your unique operational requirements.
            </p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @php
                $serviceData = [
                    ['name' => 'Security Services', 'slug' => 'security-services', 'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'desc' => 'Comprehensive physical security including armed/unarmed personnel and K-9 units.'],
                    ['name' => 'Intelligence Support', 'slug' => 'intelligence-support', 'icon' => 'M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z', 'desc' => 'Advanced intelligence analysis, risk assessment, and national security.'],
                    ['name' => 'Technology', 'slug' => 'technology-services', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'desc' => 'Cutting-edge sensors, UAS/cUAS systems, and API platforms.'],
                    ['name' => 'Contingency Ops', 'slug' => 'contingency-operations', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Rapid deployment for expeditionary and high-risk environments.'],
                    ['name' => 'Humanitarian', 'slug' => 'humanitarian', 'icon' => 'M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z', 'desc' => 'UXO mitigation, disaster response, and environmental remediation.'],
                    ['name' => 'Training', 'slug' => 'training-services', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'desc' => 'World-class training programs at state-of-the-art facilities.'],
                    ['name' => 'Facilities', 'slug' => 'facilities-base-operations', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'desc' => 'Complete facility management and base operations support.'],
                    ['name' => 'Emergency', 'slug' => 'emergency-services', 'icon' => 'M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0z', 'desc' => 'Professional firefighting, investigation, and EMS services.'],
                ];
            @endphp

            @foreach($serviceData as $i => $svc)
                <a href="{{ url('/what-we-do/' . $svc['slug']) }}" class="service-card group" data-animate style="animation-delay: {{ $i * 100 }}ms">
                    <div class="service-icon mb-6">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $svc['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-slate-900 font-display font-semibold text-lg mb-3 group-hover:text-blue-600 transition-colors">{{ $svc['name'] }}</h3>
                    <p class="text-slate-400 text-sm leading-relaxed mb-5">{{ $svc['desc'] }}</p>
                    <span class="inline-flex items-center gap-2 text-blue-600 text-sm font-semibold group-hover:gap-3 transition-all duration-300">
                        Learn More
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </span>
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     IMAGE SHOWCASE — Full-width with parallax
     ============================================================ --}}
<section class="relative h-[500px] overflow-hidden img-clip-slant" id="showcase">
    <div class="absolute inset-0 img-placeholder animate-ken-burns" style="animation-duration: 30s">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 via-blue-800/60 to-transparent z-10"></div>
        <div class="absolute inset-0 flex items-center z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-lg text-white" data-animate>
                    <h2 class="text-4xl font-display font-bold mb-4">20+ Years of Operational Excellence</h2>
                    <p class="text-blue-100/90 text-lg mb-8">Trusted by governments, agencies, and organizations in over 35 countries worldwide.</p>
                    <a href="{{ url('/who-we-are/constellis-history') }}" class="btn-white">Our History</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ============================================================
     DIVISIONS
     ============================================================ --}}
<section class="relative py-24 bg-white" id="divisions" data-animate>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <span class="text-slate-400 text-sm font-semibold tracking-wider uppercase">Our Operating Brands</span>
        </div>
        <div class="flex flex-wrap justify-center items-center gap-8 md:gap-16">
            @php /** @var \App\Models\Division $division */ @endphp
            @forelse($divisions ?? [] as $division)
                <div class="px-6 py-3 rounded-xl border border-slate-100 text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 transition-all duration-300 font-display text-lg font-bold tracking-wide cursor-default">
                    {{ $division->name }}
                </div>
            @empty
                @foreach(['Triple Canopy', 'Centerra', 'AMK9', 'Olive Group', 'Omniplex', 'TDI', 'Academi'] as $name)
                    <div class="px-6 py-3 rounded-xl border border-slate-100 text-slate-400 hover:text-blue-600 hover:border-blue-100 hover:bg-blue-50 transition-all duration-300 font-display text-lg font-bold tracking-wide cursor-default">
                        {{ $name }}
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     PLATFORM ACCESS — Complete portal CTA
     ============================================================ --}}
<section class="relative py-28 overflow-hidden" id="platform-cta">
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900"></div>
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="blob w-[400px] h-[400px] bg-sky-400/10 top-0 right-0 animate-morph"></div>
    <div class="blob w-[300px] h-[300px] bg-blue-300/10 bottom-0 left-10 animate-morph" style="animation-delay:-3s"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16" data-animate>
            <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Explore the Platform</span>
            <h2 class="section-heading-white mb-6">Your Gateway to Constellis</h2>
            <p class="text-blue-100/80 text-lg max-w-2xl mx-auto">From career opportunities to project tracking, everything you need in one secure platform.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6" data-animate>
            @php
                $platformLinks = [
                    ['title' => 'Career Opportunities', 'desc' => 'Join 20,000+ professionals making a global impact', 'url' => '/careers', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z', 'locked' => false],
                    ['title' => 'Active Projects', 'desc' => 'Track operations across 35+ countries worldwide', 'url' => '/projects', 'icon' => 'M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4', 'locked' => true],
                    ['title' => 'Employee Store', 'desc' => 'Exclusive branded merchandise for our team members', 'url' => '/store/login', 'icon' => 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z', 'locked' => true],
                    ['title' => 'Intranet Portal', 'desc' => 'Messaging, documents, and team announcements', 'url' => '/login?redirect=/intranet', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6', 'locked' => true],
                ];
            @endphp
            @foreach($platformLinks as $pl)
                <a href="{{ url($pl['url']) }}" class="glass-card p-7 text-center group hover:bg-white/20">
                    <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center text-white mx-auto mb-4 group-hover:bg-white/20 transition-all">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $pl['icon'] }}"/></svg>
                    </div>
                    <h3 class="text-white font-display font-semibold text-lg mb-2">{{ $pl['title'] }}</h3>
                    <p class="text-blue-200/70 text-sm mb-3">{{ $pl['desc'] }}</p>
                    @if($pl['locked'])
                        <span class="inline-flex items-center gap-1.5 text-blue-300 text-xs font-medium">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            Requires Login
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 text-blue-200 text-xs font-medium group-hover:gap-2.5 transition-all">
                            Explore
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    @endif
                </a>
            @endforeach
        </div>
    </div>
</section>

{{-- ============================================================
     NEWS SECTION
     ============================================================ --}}
<section class="relative py-28 bg-slate-50" id="news">
    <div class="absolute inset-0 bg-mesh-2"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="flex flex-col md:flex-row items-start md:items-end justify-between mb-14" data-animate>
            <div>
                <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-4 block">Latest Updates</span>
                <h2 class="section-heading">News & <span class="gradient-text">Insights</span></h2>
            </div>
            <a href="{{ url('/news') }}" class="btn-outline mt-6 md:mt-0">
                View All News
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
        </div>

        <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            @php /** @var \App\Models\NewsArticle $article */ @endphp
            @forelse($latestNews ?? [] as $i => $article)
                <a href="{{ url('/news/' . $article->slug) }}" class="news-card group" data-animate style="animation-delay: {{ $i * 150 }}ms">
                    <div class="overflow-hidden img-hover-shine">
                        @if($article->featured_image)
                            <img src="{{ asset('storage/' . $article->featured_image) }}" alt="{{ $article->title }}" class="news-image">
                        @else
                            <div class="img-placeholder h-56 relative">
                                <div class="absolute inset-0 flex items-center justify-center z-10">
                                    <svg class="w-10 h-10 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="p-7">
                        <time class="text-blue-600 text-xs font-bold tracking-wider uppercase">
                            {{ $article->published_at?->format('M d, Y') ?? 'Recent' }}
                        </time>
                        <h3 class="text-slate-900 font-display font-semibold text-lg mt-3 mb-3 leading-snug group-hover:text-blue-600 transition-colors line-clamp-2">
                            {{ $article->title }}
                        </h3>
                        <p class="text-slate-400 text-sm leading-relaxed line-clamp-2">
                            {{ $article->excerpt ?? Str::limit(strip_tags($article->content), 120) }}
                        </p>
                        <span class="inline-flex items-center gap-2 text-blue-600 text-sm font-semibold mt-5 group-hover:gap-3 transition-all">
                            Read More
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </span>
                    </div>
                </a>
            @empty
                @php
                    $fallbackNews = [
                        ['title' => 'Constellis Strengthens Executive Team with Addition of Joseph Zobro as Chief Legal and Compliance Officer', 'date' => 'Mar 2026'],
                        ['title' => 'Constellis Appoints Executive Vice President of LEXSO™ to Lead Strategic Growth', 'date' => 'Feb 2026'],
                        ['title' => 'Constellis\' AMK9 to Donate K9 Officer to Currituck County Sheriff\'s Office', 'date' => 'Jan 2026'],
                    ];
                @endphp
                @foreach($fallbackNews as $i => $article)
                    <div class="news-card group" data-animate style="animation-delay: {{ $i * 150 }}ms">
                        <div class="overflow-hidden img-hover-shine">
                            <div class="img-placeholder h-56 relative">
                                <div class="absolute inset-0 flex items-center justify-center z-10">
                                    <svg class="w-10 h-10 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="0.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                                </div>
                            </div>
                        </div>
                        <div class="p-7">
                            <time class="text-blue-600 text-xs font-bold tracking-wider uppercase">{{ $article['date'] }}</time>
                            <h3 class="text-slate-900 font-display font-semibold text-lg mt-3 mb-3 leading-snug line-clamp-2">{{ $article['title'] }}</h3>
                            <span class="inline-flex items-center gap-2 text-blue-600 text-sm font-semibold mt-2">
                                Read More <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                            </span>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- ============================================================
     FINAL CTA
     ============================================================ --}}
<section class="relative py-28 bg-white overflow-hidden" id="cta">
    <div class="absolute inset-0 bg-mesh-1"></div>
    <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-blue-200 to-transparent"></div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative text-center" data-animate>
        <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-blue-50 text-blue-600 text-xs font-bold tracking-wider uppercase mb-8">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            Get Started Today
        </div>
        <h2 class="section-heading mb-6">
            Ready to Secure <span class="gradient-text">Your Future</span>?
        </h2>
        <p class="section-subheading mx-auto mb-10">
            Contact our team to discuss how Constellis can provide customized security, intelligence, and training solutions for your organization.
        </p>
        <div class="flex flex-wrap justify-center gap-4">
            <a href="{{ url('/contact') }}" class="btn-primary text-base px-10 py-4">
                Get Started
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
            </a>
            <a href="tel:18663491506" class="btn-outline text-base px-10 py-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                Call Us Now
            </a>
        </div>
    </div>
</section>

@endsection
