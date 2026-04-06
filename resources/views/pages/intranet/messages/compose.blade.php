@extends('layouts.app')
@section('title', 'Compose Message — Constellis Intranet')

@section('content')
<section class="py-8 bg-slate-50 min-h-screen -mt-20 pt-28">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('intranet.inbox') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">← Back to Inbox</a>
        <h1 class="text-2xl font-display font-bold text-slate-900 mt-4 mb-6">Compose Message</h1>
        <div class="card p-8">
            <form action="{{ route('intranet.send') }}" method="POST" class="space-y-5">
                @csrf
                <div>
                    <label for="to_user_id" class="block text-slate-700 text-sm font-semibold mb-2">To *</label>
                    <select id="to_user_id" name="to_user_id" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all">
                        <option value="">Select recipient...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->department ?? $user->role }})</option>
                        @endforeach
                    </select>
                    @error('to_user_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="subject" class="block text-slate-700 text-sm font-semibold mb-2">Subject</label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}"
                           class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="Message subject...">
                </div>
                <div>
                    <label for="body" class="block text-slate-700 text-sm font-semibold mb-2">Message *</label>
                    <textarea id="body" name="body" rows="8" required
                              class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none" placeholder="Write your message...">{{ old('body') }}</textarea>
                    @error('body') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="btn-primary">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    Send Message
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
