@extends('layouts.app')
@section('title', 'Announcements — Constellis Intranet')

@section('content')
<section class="py-8 bg-slate-50 min-h-screen -mt-20 pt-28">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('intranet.dashboard') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">← Dashboard</a>
        <h1 class="text-2xl font-display font-bold text-slate-900 mt-4 mb-8">Announcements</h1>
        <div class="space-y-4">
            @forelse($announcements as $ann)
                <div class="card p-6 {{ $ann->is_pinned ? 'border-l-4 border-l-amber-400' : '' }} {{ $ann->priority === 'urgent' ? 'border-l-4 border-l-red-500' : '' }}">
                    <div class="flex items-start justify-between mb-3">
                        <div class="flex items-center gap-2">
                            @if($ann->is_pinned)<span class="text-amber-500 text-lg">📌</span>@endif
                            <h2 class="font-display font-semibold text-slate-900 text-lg">{{ $ann->title }}</h2>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="px-2 py-0.5 rounded-full text-xs font-medium {{ $ann->priority === 'urgent' ? 'bg-red-50 text-red-700' : ($ann->priority === 'high' ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-500') }} capitalize">{{ $ann->priority }}</span>
                            <span class="text-slate-400 text-xs">{{ $ann->published_at?->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="prose prose-slate prose-sm max-w-none text-slate-600">{!! nl2br(e($ann->body)) !!}</div>
                    <p class="text-slate-400 text-xs mt-4">By {{ $ann->author->name ?? 'System' }}</p>
                </div>
            @empty
                <div class="text-center py-20"><p class="text-slate-400">No announcements at this time.</p></div>
            @endforelse
        </div>
        <div class="mt-6">{{ $announcements->links() }}</div>
    </div>
</section>
@endsection
