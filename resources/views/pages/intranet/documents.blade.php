@extends('layouts.app')
@section('title', 'Documents — Constellis Intranet')

@section('content')
<section class="py-8 bg-slate-50 min-h-screen -mt-20 pt-28">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('intranet.dashboard') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">← Dashboard</a>
        <h1 class="text-2xl font-display font-bold text-slate-900 mt-4 mb-8">Shared Documents</h1>

        {{-- Filters --}}
        <div class="flex flex-wrap gap-2 mb-6">
            <a href="{{ route('intranet.documents') }}" class="px-4 py-2 rounded-full text-sm font-medium {{ !request('category') ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-blue-50' }} transition-all">All</a>
            @foreach(['general', 'policy', 'procedure', 'training', 'hr'] as $cat)
                <a href="{{ route('intranet.documents', ['category' => $cat]) }}" class="px-4 py-2 rounded-full text-sm font-medium capitalize {{ request('category') === $cat ? 'bg-blue-600 text-white' : 'bg-white text-slate-600 hover:bg-blue-50' }} transition-all">{{ $cat }}</a>
            @endforeach
        </div>

        <div class="space-y-3">
            @forelse($documents as $doc)
                <div class="card p-5 flex items-center gap-4">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-slate-900 font-semibold text-sm truncate">{{ $doc->title }}</h3>
                        <div class="flex items-center gap-3 mt-1">
                            <span class="text-slate-400 text-xs capitalize">{{ $doc->category }}</span>
                            <span class="text-slate-300">·</span>
                            <span class="text-slate-400 text-xs">{{ $doc->file_size_human }}</span>
                            <span class="text-slate-300">·</span>
                            <span class="text-slate-400 text-xs">{{ $doc->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <a href="{{ route('intranet.document.download', $doc) }}" class="w-10 h-10 rounded-xl bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-blue-50 hover:text-blue-600 transition-all shrink-0">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </a>
                </div>
            @empty
                <div class="text-center py-20"><p class="text-slate-400">No documents available.</p></div>
            @endforelse
        </div>
        <div class="mt-6">{{ $documents->links() }}</div>
    </div>
</section>
@endsection
