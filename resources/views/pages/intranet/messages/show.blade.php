@extends('layouts.app')
@section('title', 'Message — Constellis Intranet')

@section('content')
<section class="py-8 bg-slate-50 min-h-screen -mt-20 pt-28">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <a href="{{ route('intranet.inbox') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">← Back to Inbox</a>
        <div class="card p-8 mt-4">
            <div class="flex items-start justify-between mb-6 pb-6 border-b border-slate-100">
                <div>
                    <h1 class="text-xl font-display font-bold text-slate-900">{{ $message->subject ?? '(No subject)' }}</h1>
                    <div class="flex items-center gap-4 mt-2 text-sm text-slate-500">
                        <span><strong>From:</strong> {{ $message->sender->name }}</span>
                        <span><strong>To:</strong> {{ $message->recipient->name }}</span>
                        <span>{{ $message->created_at->format('M d, Y \a\t g:i A') }}</span>
                    </div>
                </div>
            </div>
            <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                {!! nl2br(e($message->body)) !!}
            </div>
        </div>
    </div>
</section>
@endsection
