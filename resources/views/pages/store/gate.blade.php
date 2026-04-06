@extends('layouts.app')
@section('title', 'Employee Store — Constellis')

@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-slate-800 via-slate-900 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-10"></div>
    <div class="max-w-xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="w-20 h-20 rounded-3xl bg-white/10 backdrop-blur-sm border border-white/20 flex items-center justify-center text-white mx-auto mb-8">
            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <h1 class="text-3xl font-display font-bold text-white mb-4">Employee Store Access</h1>
        <p class="text-slate-400 mb-8">This store is exclusively available to Constellis employees. Please log in with your employee credentials.</p>

        @if(session('error'))
            <div class="card p-4 border-red-300 bg-red-50 mb-6 text-left"><p class="text-red-800 text-sm">{{ session('error') }}</p></div>
        @endif

        <form action="{{ route('store.login') }}" method="POST" class="text-left space-y-4">
            @csrf
            <div>
                <label for="store-email" class="block text-white text-sm font-semibold mb-2">Employee Email</label>
                <input type="email" id="store-email" name="email" required
                       class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:outline-none transition-all backdrop-blur-sm" placeholder="you@constellis.com">
                @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="store-password" class="block text-white text-sm font-semibold mb-2">Password</label>
                <input type="password" id="store-password" name="password" required
                       class="w-full px-4 py-3.5 rounded-xl bg-white/10 border border-white/20 text-white placeholder-white/40 focus:border-blue-400 focus:ring-2 focus:ring-blue-400/20 focus:outline-none transition-all backdrop-blur-sm" placeholder="••••••••">
            </div>
            <button type="submit" class="btn-white w-full py-4">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
                Access Store
            </button>
        </form>

        <a href="{{ url('/') }}" class="inline-block text-slate-500 hover:text-white text-sm mt-6 transition-colors">← Return to Homepage</a>
    </div>
</section>
@endsection
