@extends('layouts.app')
@section('title', 'Login — Constellis')

@section('content')
<section class="relative min-h-[80vh] flex items-center justify-center overflow-hidden bg-gradient-to-br from-slate-800 via-slate-900 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-10"></div>
    <div class="max-w-md w-full mx-auto px-4 relative z-10">
        <div class="text-center mb-8">
            <a href="{{ url('/') }}" class="inline-flex items-center gap-3 mb-6">
                <img src="{{ asset('images/NSG.png') }}"
                     alt="National Security Group"
                     class="h-16 w-auto drop-shadow-lg">
            </a>
            <h1 class="text-2xl font-display font-bold text-white mb-2">Sign In</h1>
            <p class="text-slate-400 text-sm">Access your account to use protected features</p>
        </div>

        @if(session('error'))
            <div class="card p-4 border-red-300 bg-red-50 mb-6"><p class="text-red-800 text-sm">{{ session('error') }}</p></div>
        @endif

        <form action="{{ route('login.submit') }}" method="POST" class="space-y-5">
            @csrf
            @if(request('redirect'))<input type="hidden" name="redirect" value="{{ request('redirect') }}">@endif
            <div>
                <label for="email" class="block text-white text-sm font-semibold mb-2">Email</label>
                <input type="email" id="email" name="email" required value="{{ old('email') }}"
                       class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:outline-none transition-all backdrop-blur-sm" placeholder="you@constellis.com">
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="password" class="block text-white text-sm font-semibold mb-2">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:outline-none transition-all backdrop-blur-sm" placeholder="••••••••">
            </div>
            <div class="flex items-center gap-2">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 rounded border-white/20 bg-white/10 text-blue-600 focus:ring-blue-500">
                <label for="remember" class="text-slate-300 text-sm">Remember me</label>
            </div>
            <button type="submit" class="btn-white w-full py-4">Sign In</button>
        </form>
        <a href="{{ url('/') }}" class="block text-center text-slate-500 hover:text-white text-sm mt-6 transition-colors">← Return to Homepage</a>
    </div>
</section>
@endsection
