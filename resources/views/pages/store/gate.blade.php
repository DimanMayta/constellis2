@extends('layouts.app')
@section('title', 'Employee Store — NSG')

@section('content')
<section class="relative min-h-screen flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950" x-data>
    {{-- Background effects --}}
    <div class="absolute inset-0">
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_rgba(59,130,246,0.15),transparent_60%)]"></div>
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_bottom_left,_rgba(99,102,241,0.1),transparent_60%)]"></div>
        <div class="absolute inset-0 line-grid opacity-5"></div>
    </div>

    <div class="max-w-md w-full mx-auto px-4 sm:px-6 relative z-10 py-16">
        {{-- Logo / Icon --}}
        <div class="text-center mb-8">
            <div class="w-20 h-20 rounded-3xl bg-white/5 backdrop-blur-sm border border-white/10 flex items-center justify-center text-white mx-auto mb-6 shadow-2xl">
                <svg class="w-10 h-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.06.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.15c0 .415.336.75.75.75z"/></svg>
            </div>



            <h1 class="text-3xl font-display font-bold text-white tracking-tight"
                x-text="$store.lang.current === 'en' ? 'Employee Store' : 'Tienda de Empleados'"></h1>
            <p class="text-slate-400 mt-2 text-sm leading-relaxed max-w-sm mx-auto"
               x-text="$store.lang.current === 'en' ? 'Exclusive access for NSG team members. Log in with your employee credentials.' : 'Acceso exclusivo para miembros del equipo NSG. Inicie sesión con sus credenciales de empleado.'"></p>
        </div>

        {{-- Error messages --}}
        @if(session('error'))
            <div class="p-4 rounded-2xl border border-red-500/20 bg-red-500/10 backdrop-blur-sm mb-6">
                <p class="text-red-300 text-sm font-medium text-center">{{ session('error') }}</p>
            </div>
        @endif

        @if($errors->has('email'))
            @php $errCode = $errors->first('email'); @endphp

            @if($errCode === 'locked')
                <div class="p-4 rounded-2xl border border-red-500/20 bg-red-500/10 backdrop-blur-sm mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 text-red-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    <p class="text-red-300 text-sm font-medium"
                       x-text="$store.lang.current === 'en' ? 'Your account has been locked due to too many failed login attempts. Please contact an administrator to unlock your account.' : 'Su cuenta ha sido bloqueada debido a demasiados intentos fallidos de inicio de sesión. Contacte a un administrador para desbloquear su cuenta.'"></p>
                </div>

            @elseif(str_starts_with($errCode, 'attempts:'))
                @php $remaining = (int) str_replace('attempts:', '', $errCode); @endphp
                <div class="p-4 rounded-2xl border border-amber-500/20 bg-amber-500/10 backdrop-blur-sm mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 text-amber-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.34 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
                    <p class="text-amber-300 text-sm font-medium"
                       x-text="$store.lang.current === 'en' ? 'Invalid credentials. You have {{ $remaining }} attempt(s) remaining before your account is locked.' : 'Credenciales inválidas. Le quedan {{ $remaining }} intento(s) antes de que su cuenta sea bloqueada.'"></p>
                </div>

            @elseif($errCode === 'no_access')
                <div class="p-4 rounded-2xl border border-red-500/20 bg-red-500/10 backdrop-blur-sm mb-6">
                    <p class="text-red-300 text-sm font-medium text-center"
                       x-text="$store.lang.current === 'en' ? 'Your account does not have store access.' : 'Su cuenta no tiene acceso a la tienda.'"></p>
                </div>

            @elseif($errCode === 'invalid')
                <div class="p-4 rounded-2xl border border-red-500/20 bg-red-500/10 backdrop-blur-sm mb-6">
                    <p class="text-red-300 text-sm font-medium text-center"
                       x-text="$store.lang.current === 'en' ? 'Invalid credentials. Please try again.' : 'Credenciales inválidas. Inténtelo de nuevo.'"></p>
                </div>

            @else
                <div class="p-4 rounded-2xl border border-red-500/20 bg-red-500/10 backdrop-blur-sm mb-6">
                    <p class="text-red-300 text-sm">{{ $errCode }}</p>
                </div>
            @endif
        @endif

        {{-- Login Form --}}
        <form action="{{ route('store.login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="store-email" class="block text-white/80 text-sm font-semibold mb-2"
                       x-text="$store.lang.current === 'en' ? 'Employee Email' : 'Correo del Empleado'"></label>
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                    <input type="email" id="store-email" name="email" required value="{{ old('email') }}"
                           class="w-full pl-12 pr-4 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/30 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:outline-none transition-all backdrop-blur-sm text-sm" placeholder="you@nsg.com">
                </div>
            </div>
            <div>
                <label for="store-password" class="block text-white/80 text-sm font-semibold mb-2"
                       x-text="$store.lang.current === 'en' ? 'Password' : 'Contraseña'"></label>
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-white/30" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    <input type="password" id="store-password" name="password" required
                           class="w-full pl-12 pr-4 py-3.5 rounded-xl bg-white/5 border border-white/10 text-white placeholder-white/30 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:outline-none transition-all backdrop-blur-sm text-sm" placeholder="••••••••">
                </div>
            </div>
            <button type="submit"
                    class="w-full flex items-center justify-center gap-2 py-4 rounded-xl bg-white text-slate-900 font-bold text-sm hover:bg-blue-50 transition-all shadow-xl shadow-black/20 active:scale-[0.98]">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 9V5.25A2.25 2.25 0 0110.5 3h6a2.25 2.25 0 012.25 2.25v13.5A2.25 2.25 0 0116.5 21h-6a2.25 2.25 0 01-2.25-2.25V15m-3 0l-3-3m0 0l3-3m-3 3H15"/></svg>
                <span x-text="$store.lang.current === 'en' ? 'Access Store' : 'Acceder a la Tienda'"></span>
            </button>
        </form>

        <div class="text-center mt-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-white text-sm transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span x-text="$store.lang.current === 'en' ? 'Return to Homepage' : 'Volver al Inicio'"></span>
            </a>
        </div>
    </div>
</section>
@endsection
