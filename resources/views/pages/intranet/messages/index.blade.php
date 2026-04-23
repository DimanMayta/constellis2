@extends('layouts.app')
@section('title', 'Inbox — Constellis Intranet')

@section('content')
<section class="py-8 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between mb-8">
            <div><a href="{{ route('intranet.dashboard') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">← Dashboard</a><h1 class="text-2xl font-display font-bold text-slate-900 mt-2">Inbox</h1></div>
            <a href="{{ route('intranet.compose') }}" class="btn-primary py-2.5 px-5 text-sm">Compose</a>
        </div>
        <div class="card overflow-hidden">
            @forelse($messages as $msg)
                <a href="{{ route('intranet.message', $msg) }}" class="block p-5 border-b border-slate-50 hover:bg-slate-50 transition-colors {{ !$msg->isRead() ? 'bg-blue-50/30' : '' }}">
                    <div class="flex items-center justify-between mb-1">
                        <span class="font-semibold text-sm {{ !$msg->isRead() ? 'text-blue-700' : 'text-slate-900' }}">{{ $msg->sender->name }}</span>
                        <span class="text-slate-400 text-xs">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-slate-700 text-sm font-medium">{{ $msg->subject ?? '(No subject)' }}</p>
                    <p class="text-slate-400 text-xs mt-1 line-clamp-1">{{ Str::limit($msg->body, 120) }}</p>
                </a>
            @empty
                <div class="p-12 text-center"><p class="text-slate-400">Your inbox is empty.</p></div>
            @endforelse
        </div>
        <div class="mt-6">{{ $messages->links() }}</div>
    </div>
</section>
@endsection
