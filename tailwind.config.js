import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
    ],
    theme: {
        extend: {
            colors: {
                // Brand Primary — Navy Blue
                blue: {
                    50: '#eef2f8',
                    100: '#d4dce9',
                    200: '#a9b9d3',
                    300: '#7e96bd',
                    400: '#5373a7',
                    500: '#2d5287',
                    600: '#244472',
                    700: '#1d345d',
                    800: '#162848',
                    900: '#0f1c33',
                    950: '#0a1221',
                },
                // Brand Secondary — Steel Blue
                steel: {
                    50: '#f4f5f7',
                    100: '#e8eaef',
                    200: '#d1d4df',
                    300: '#b5b9c7',
                    400: '#9298af',
                    500: '#7a8098',
                    600: '#636880',
                    700: '#4d5168',
                    800: '#3a3d50',
                    900: '#282a38',
                },
                // Brand Accent — Red
                accent: {
                    50: '#fef2f2',
                    100: '#fde3e4',
                    200: '#fbc7c9',
                    300: '#f69a9e',
                    400: '#ef6269',
                    500: '#e7333e',
                    600: '#d41e2a',
                    700: '#b2161f',
                    800: '#93161d',
                    900: '#7a181e',
                    950: '#43080b',
                },
                // Brand Light — Mint
                mint: {
                    50: '#f7fbf7',
                    100: '#eff6ef',
                    200: '#deedde',
                    300: '#c5dfc5',
                    400: '#9ec99e',
                    500: '#7bb37b',
                },
                // Slate (neutral grays)
                slate: {
                    50: '#f8fafc',
                    100: '#f1f5f9',
                    200: '#e2e8f0',
                    300: '#cbd5e1',
                    400: '#94a3b8',
                    500: '#64748b',
                    600: '#475569',
                    700: '#334155',
                    800: '#1e293b',
                    900: '#0f172a',
                    950: '#020617',
                },
            },
            fontFamily: {
                sans: ['Open Sans', ...defaultTheme.fontFamily.sans],
                display: ['Raleway', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'fade-in': 'fadeIn 0.6s ease-out forwards',
                'fade-in-up': 'fadeInUp 0.8s ease-out forwards',
                'fade-in-left': 'fadeInLeft 0.6s ease-out forwards',
                'fade-in-right': 'fadeInRight 0.6s ease-out forwards',
                'slide-down': 'slideDown 0.3s ease-out forwards',
                'slide-up': 'slideUp 0.5s ease-out forwards',
                'float': 'float 6s ease-in-out infinite',
                'float-slow': 'float 10s ease-in-out infinite',
                'shimmer': 'shimmer 2.5s linear infinite',
                'spin-slow': 'spin 20s linear infinite',
                'pulse-soft': 'pulseSoft 4s ease-in-out infinite',
                'gradient-x': 'gradientX 8s ease-in-out infinite',
                'scale-in': 'scaleIn 0.5s ease-out forwards',
                'parallax-slow': 'parallaxSlow 30s linear infinite',
                'morph': 'morph 8s ease-in-out infinite',
                'ken-burns': 'kenBurns 20s ease-in-out infinite alternate',
                'glow-pulse': 'glowPulse 3s ease-in-out infinite',
            },
            keyframes: {
                fadeIn: {
                    '0%': { opacity: '0' },
                    '100%': { opacity: '1' },
                },
                fadeInUp: {
                    '0%': { opacity: '0', transform: 'translateY(40px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                fadeInLeft: {
                    '0%': { opacity: '0', transform: 'translateX(-40px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                fadeInRight: {
                    '0%': { opacity: '0', transform: 'translateX(40px)' },
                    '100%': { opacity: '1', transform: 'translateX(0)' },
                },
                slideDown: {
                    '0%': { opacity: '0', transform: 'translateY(-10px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                slideUp: {
                    '0%': { opacity: '0', transform: 'translateY(20px)' },
                    '100%': { opacity: '1', transform: 'translateY(0)' },
                },
                float: {
                    '0%, 100%': { transform: 'translateY(0)' },
                    '50%': { transform: 'translateY(-15px)' },
                },
                pulseSoft: {
                    '0%, 100%': { opacity: '0.4' },
                    '50%': { opacity: '0.8' },
                },
                gradientX: {
                    '0%, 100%': { backgroundPosition: '0% 50%' },
                    '50%': { backgroundPosition: '100% 50%' },
                },
                scaleIn: {
                    '0%': { opacity: '0', transform: 'scale(0.9)' },
                    '100%': { opacity: '1', transform: 'scale(1)' },
                },
                parallaxSlow: {
                    '0%': { transform: 'translateX(0) translateY(0)' },
                    '100%': { transform: 'translateX(-50px) translateY(-30px)' },
                },
                morph: {
                    '0%, 100%': { borderRadius: '60% 40% 30% 70%/60% 30% 70% 40%' },
                    '50%': { borderRadius: '30% 60% 70% 40%/50% 60% 30% 60%' },
                },
                kenBurns: {
                    '0%': { transform: 'scale(1)' },
                    '100%': { transform: 'scale(1.1)' },
                },
                glowPulse: {
                    '0%, 100%': { boxShadow: '0 0 20px rgba(29,52,93,0.2), 0 0 60px rgba(29,52,93,0.1)' },
                    '50%': { boxShadow: '0 0 30px rgba(29,52,93,0.4), 0 0 80px rgba(29,52,93,0.2)' },
                },
                shimmer: {
                    '0%': { backgroundPosition: '-200% 0' },
                    '100%': { backgroundPosition: '200% 0' },
                },
            },
            backgroundImage: {
                'hero-blue': 'linear-gradient(135deg, #0f1c33 0%, #1d345d 40%, #2d5287 70%, #5373a7 100%)',
                'hero-radial': 'radial-gradient(ellipse at 30% 50%, rgba(29,52,93,0.15) 0%, transparent 60%)',
                'card-shine': 'linear-gradient(135deg, rgba(255,255,255,0) 0%, rgba(255,255,255,0.05) 50%, rgba(255,255,255,0) 100%)',
                'mesh-1': 'radial-gradient(at 20% 30%, rgba(29,52,93,0.08) 0%, transparent 50%), radial-gradient(at 80% 70%, rgba(146,152,175,0.06) 0%, transparent 50%)',
                'mesh-2': 'radial-gradient(at 70% 20%, rgba(29,52,93,0.1) 0%, transparent 50%), radial-gradient(at 30% 80%, rgba(146,152,175,0.08) 0%, transparent 50%)',
            },
            boxShadow: {
                'blue-sm': '0 2px 15px rgba(29,52,93,0.08)',
                'blue-md': '0 4px 25px rgba(29,52,93,0.12)',
                'blue-lg': '0 8px 40px rgba(29,52,93,0.15)',
                'blue-xl': '0 12px 60px rgba(29,52,93,0.2)',
                'card': '0 1px 3px rgba(0,0,0,0.04), 0 4px 20px rgba(0,0,0,0.04)',
                'card-hover': '0 8px 40px rgba(0,0,0,0.08), 0 2px 10px rgba(29,52,93,0.06)',
                'inner-white': 'inset 0 1px 0 0 rgba(255,255,255,0.8)',
            },
        },
    },
    plugins: [],
};
