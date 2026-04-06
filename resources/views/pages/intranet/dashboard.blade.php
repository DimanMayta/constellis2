@extends('layouts.app')
@section('title', 'Intranet — Constellis')

@section('content')
<section class="py-8 bg-slate-50 min-h-screen -mt-20 pt-28">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-display font-bold text-slate-900">Intranet Dashboard</h1>
                <p class="text-slate-500 text-sm">Welcome back, {{ auth()->user()->name }}</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('intranet.chat') }}" class="btn-primary py-2.5 px-5 text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    Open Chat
                </a>
                <form action="{{ route('logout') }}" method="POST">@csrf<button type="submit" class="btn-outline py-2.5 px-5 text-sm">Sign Out</button></form>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            {{-- Quick Stats --}}
            <div class="lg:col-span-3 grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="card p-5"><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Unread Messages</p><p class="text-2xl font-display font-bold text-slate-900" data-unread-count>{{ $unreadCount }}</p></div>
                <div class="card p-5"><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Announcements</p><p class="text-2xl font-display font-bold text-slate-900">{{ $announcements->count() }}</p></div>
                <div class="card p-5"><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Documents</p><p class="text-2xl font-display font-bold text-slate-900">{{ $recentDocuments->count() }}</p></div>
                <div class="card p-5"><p class="text-slate-400 text-xs uppercase tracking-wide mb-1">Online Now</p><p class="text-2xl font-display font-bold text-green-600"><span class="inline-block w-2 h-2 rounded-full bg-green-500 animate-pulse mr-1.5"></span><span id="online-count">—</span></p></div>
            </div>

            {{-- Recent Messages --}}
            <div class="lg:col-span-2">
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-display font-semibold text-slate-900">Recent Messages</h2>
                        <a href="{{ route('intranet.chat') }}" class="text-blue-600 text-sm font-medium hover:text-blue-700">Open Chat →</a>
                    </div>
                    <div class="space-y-2">
                        @forelse($recentMessages as $msg)
                            <a href="{{ route('intranet.chat') }}" class="block p-4 rounded-xl hover:bg-slate-50 transition-colors {{ !$msg->isRead() ? 'bg-blue-50/50 border border-blue-100' : '' }}">
                                <div class="flex items-center justify-between mb-1">
                                    <span class="text-slate-900 font-semibold text-sm {{ !$msg->isRead() ? 'text-blue-700' : '' }}">{{ $msg->sender->name }}</span>
                                    <span class="text-slate-400 text-xs">{{ $msg->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-slate-400 text-xs mt-1 line-clamp-1">{{ Str::limit($msg->body, 100) }}</p>
                            </a>
                        @empty
                            <p class="text-slate-400 text-sm py-8 text-center">No messages yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Quick Links --}}
                <div class="card p-6">
                    <h2 class="font-display font-semibold text-slate-900 mb-4">Quick Links</h2>
                    <div class="space-y-2">
                        @foreach([
                            ['Chat', route('intranet.chat'), 'M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z'],
                            ['Announcements', route('intranet.announcements'), 'M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z'],
                            ['Documents', route('intranet.documents'), 'M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z'],
                        ] as $link)
                            <a href="{{ $link[1] }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-blue-50 transition-colors group">
                                <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $link[2] }}"/></svg>
                                </div>
                                <span class="text-slate-700 text-sm font-medium group-hover:text-blue-700">{{ $link[0] }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>

                {{-- Announcements --}}
                <div class="card p-6">
                    <h2 class="font-display font-semibold text-slate-900 mb-4">Announcements</h2>
                    <div class="space-y-3">
                        @forelse($announcements->take(3) as $ann)
                            <div class="p-3 rounded-xl bg-slate-50">
                                <div class="flex items-center gap-2 mb-1">
                                    @if($ann->is_pinned)<span class="text-amber-500">📌</span>@endif
                                    <span class="text-slate-900 font-semibold text-sm">{{ $ann->title }}</span>
                                </div>
                                <p class="text-slate-400 text-xs">{{ $ann->published_at?->diffForHumans() }}</p>
                            </div>
                        @empty
                            <p class="text-slate-400 text-sm text-center">No announcements.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Real-time notification toast --}}
<div id="rt-notification" class="fixed bottom-6 right-6 z-50 max-w-sm transition-all duration-500 translate-y-20 opacity-0 pointer-events-none">
    <div class="card p-5 border-blue-200 bg-blue-50 shadow-xl">
        <div class="flex items-start gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center text-white shrink-0">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-blue-900 font-semibold text-sm" id="rt-sender">New Message</p>
                <p class="text-blue-700 text-xs mt-0.5" id="rt-subject">...</p>
            </div>
            <button onclick="dismissNotification()" class="text-blue-400 hover:text-blue-600 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content;

    // ─── Heartbeat: update last_seen_at and get online user count ───
    async function sendHeartbeat() {
        try {
            const res = await fetch('{{ route("intranet.chat.heartbeat") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                },
            });
            const data = await res.json();
            updateOnlineCount(data.online.length);
        } catch(e) {}
    }

    // Send heartbeat immediately, then every 10s
    sendHeartbeat();
    setInterval(sendHeartbeat, 10000);

    // ─── Echo/WebSocket fallback (when Reverb is running) ───
    if (window.Echo) {
        const userId = {{ auth()->id() }};

        window.Echo.private(`intranet.messages.${userId}`)
            .listen('.message.received', function(data) {
                showNotification(data.sender_name, data.body || data.subject || '(No subject)');

                // Update the unread count
                const unreadEl = document.querySelector('[data-unread-count]');
                if (unreadEl) {
                    const current = parseInt(unreadEl.textContent) || 0;
                    unreadEl.textContent = current + 1;
                }

                // Play notification sound
                try {
                    const ctx = new (window.AudioContext || window.webkitAudioContext)();
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.frequency.value = 800;
                    osc.type = 'sine';
                    gain.gain.value = 0.1;
                    osc.start();
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.3);
                    osc.stop(ctx.currentTime + 0.3);
                } catch(e) {}
            });

        window.Echo.join('intranet.presence')
            .here((users) => { updateOnlineCount(users.length); })
            .joining((user) => { updateOnlineCount(null, 1); })
            .leaving((user) => { updateOnlineCount(null, -1); });
    }
});

function showNotification(sender, subject) {
    const el = document.getElementById('rt-notification');
    document.getElementById('rt-sender').textContent = `From: ${sender}`;
    document.getElementById('rt-subject').textContent = subject;
    el.classList.remove('translate-y-20', 'opacity-0', 'pointer-events-none');
    el.classList.add('translate-y-0', 'opacity-100', 'pointer-events-auto');

    setTimeout(dismissNotification, 8000);
}

function dismissNotification() {
    const el = document.getElementById('rt-notification');
    el.classList.add('translate-y-20', 'opacity-0', 'pointer-events-none');
    el.classList.remove('translate-y-0', 'opacity-100', 'pointer-events-auto');
}

function updateOnlineCount(count, delta) {
    const el = document.getElementById('online-count');
    if (!el) return;
    if (count !== null && count !== undefined) { el.textContent = count; }
    else { el.textContent = Math.max(0, (parseInt(el.textContent) || 0) + delta); }
}
</script>
@endpush
@endsection
