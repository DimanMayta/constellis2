@extends('layouts.app')
@section('title', 'Chat — Constellis Intranet')

@section('content')
<section class="fixed inset-0 z-40 overflow-hidden" style="top: 5.5rem; background: linear-gradient(135deg, #eff6ef 0%, #e8eaef 50%, #eff6ef 100%)" x-data="chatApp()" x-init="init()">
    <div class="h-full flex overflow-hidden shadow-2xl">

        {{-- ═══ LEFT SIDEBAR — Contacts ═══ --}}
        <div class="w-80 lg:w-96 flex flex-col shrink-0 border-r border-steel-200" :class="{ 'hidden md:flex': activeChat }" style="background: linear-gradient(180deg, #f4f5f7 0%, #ffffff 100%)">

            {{-- Header --}}
            <div class="p-4 border-b border-blue-800/20" style="background: linear-gradient(135deg, #1d345d 0%, #0f1c33 100%)">
                <div class="flex items-center justify-between mb-3">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm" style="background: linear-gradient(135deg, #e7333e, #d41e2a)">
                            {{ substr(auth()->user()->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-white font-semibold text-sm font-display">{{ auth()->user()->name }}</p>
                            <p class="text-steel-400 text-xs capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                    <a href="{{ route('intranet.dashboard') }}" class="text-steel-400 hover:text-white transition-colors" title="Back to Dashboard">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </a>
                </div>
                {{-- Search --}}
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-steel-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="searchQuery" placeholder="Search contacts..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl bg-white/10 text-white placeholder-steel-400 text-sm focus:outline-none focus:bg-white/20 focus:ring-1 focus:ring-accent-500/50 transition-all border-0">
                </div>
            </div>

            {{-- Contact List --}}
            <div class="flex-1 overflow-y-auto">
                @forelse($contacts as $contact)
                    <button @click="openChat({{ $contact->id }}, '{{ addslashes($contact->name) }}', '{{ $contact->role }}')"
                            :class="{ 'bg-mint-100 border-l-4 border-l-accent-500': activeChat === {{ $contact->id }} }"
                            class="w-full flex items-center gap-3 px-4 py-3.5 hover:bg-mint-50 transition-all text-left border-b border-steel-100/50"
                            x-show="!searchQuery || '{{ strtolower($contact->name) }}'.includes(searchQuery.toLowerCase())">
                        <div class="relative shrink-0">
                            <div class="w-12 h-12 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md"
                                 :class="activeChat === {{ $contact->id }} ? 'bg-gradient-to-br from-accent-500 to-accent-600' : 'bg-gradient-to-br from-blue-600 to-blue-700'">
                                {{ substr($contact->name, 0, 1) }}
                            </div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 rounded-full border-2 border-white transition-colors" :class="onlineUsers.has({{ $contact->id }}) ? 'bg-green-500' : 'bg-steel-300'" id="status-{{ $contact->id }}"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-sm truncate" :class="activeChat === {{ $contact->id }} ? 'text-blue-900' : 'text-slate-800'">{{ $contact->name }}</span>
                                @if($contact->last_message)
                                    <span class="text-steel-400 text-[10px] shrink-0 ml-2">{{ $contact->last_message->created_at->format('g:i A') }}</span>
                                @endif
                            </div>
                            <div class="flex items-center justify-between mt-0.5">
                                <p class="text-steel-400 text-xs truncate">
                                    @if($contact->last_message)
                                        {{ \Str::limit($contact->last_message->body, 35) }}
                                    @else
                                        <span class="text-steel-300 italic">No messages yet</span>
                                    @endif
                                </p>
                                @if($contact->unread_from > 0)
                                    <span class="shrink-0 ml-2 w-5 h-5 rounded-full bg-accent-500 text-white text-[10px] font-bold flex items-center justify-center shadow-sm shadow-accent-500/30" id="badge-{{ $contact->id }}">
                                        {{ $contact->unread_from }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </button>
                @empty
                    <div class="p-8 text-center">
                        <p class="text-steel-400 text-sm">No contacts available.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- ═══ RIGHT PANEL — Chat Thread ═══ --}}
        <div class="flex-1 flex flex-col" :class="{ 'hidden md:flex': !activeChat }" style="background: #eff6ef">

            {{-- Empty State --}}
            <div x-show="!activeChat" class="flex-1 flex items-center justify-center" style="background: linear-gradient(180deg, #eff6ef 0%, #deedde 100%)">
                <div class="text-center">
                    <div class="w-28 h-28 rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg" style="background: linear-gradient(135deg, #1d345d, #2d5287)">
                        <svg class="w-14 h-14 text-white/80" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                    </div>
                    <h3 class="text-blue-900 font-display font-bold text-2xl mb-2">NSG Messenger</h3>
                    <p class="text-steel-400 text-sm max-w-xs">Select a contact to start a conversation.<br>Messages are delivered in real-time.</p>
                </div>
            </div>

            {{-- Chat Active --}}
            <div x-show="activeChat" x-cloak class="flex flex-col h-full">

                {{-- Chat Header --}}
                <div class="px-5 py-3.5 flex items-center gap-4 shrink-0 shadow-md" style="background: linear-gradient(135deg, #1d345d 0%, #2d5287 100%)">
                    <button @click="closeChat()" class="md:hidden text-white/60 hover:text-white mr-1">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    </button>
                    <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-md" style="background: linear-gradient(135deg, #e7333e, #d41e2a)" x-text="activeName ? activeName.charAt(0) : ''"></div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white font-display font-semibold text-sm truncate" x-text="activeName"></p>
                        <p class="text-steel-300 text-xs capitalize" x-text="activeRole"></p>
                    </div>
                    <div class="flex items-center gap-2">
                        <span x-show="onlineUsers.has(activeChat)" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-green-500/20 text-green-300 text-xs font-medium">
                            <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                            Online
                        </span>
                        <span x-show="!onlineUsers.has(activeChat)" class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/10 text-steel-300 text-xs font-medium">
                            <span class="w-2 h-2 rounded-full bg-steel-400"></span>
                            Offline
                        </span>
                    </div>
                </div>

                {{-- Messages Area --}}
                <div class="flex-1 overflow-y-auto px-5 py-4 space-y-1" id="chat-messages" x-ref="chatMessages"
                     style="background: linear-gradient(180deg, #eff6ef 0%, #deedde 40%, #eff6ef 100%); background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2760%27 height=%2760%27 viewBox=%270 0 60 60%27%3E%3Cg fill=%27none%27 stroke=%27%239298af%27 stroke-width=%270.3%27 opacity=%270.15%27%3E%3Cpath d=%27M0 30h60M30 0v60%27/%3E%3C/g%3E%3C/svg%3E')">
                    <div x-show="loading" class="flex items-center justify-center py-20">
                        <div class="w-8 h-8 border-2 border-accent-500 border-t-transparent rounded-full animate-spin"></div>
                    </div>
                    <div x-show="!loading && messages.length === 0" class="text-center py-16">
                        <div class="w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-md" style="background: linear-gradient(135deg, #1d345d, #2d5287)">
                            <svg class="w-10 h-10 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                        </div>
                        <p class="text-steel-500 text-sm font-medium">No messages yet. Say hello! 👋</p>
                    </div>
                    <template x-for="(msg, idx) in messages" :key="msg.id">
                        <div>
                            {{-- Date separator --}}
                            <template x-if="idx === 0 || messages[idx-1]?.date !== msg.date">
                                <div class="flex items-center justify-center my-4">
                                    <span class="px-4 py-1.5 rounded-full text-[10px] font-semibold tracking-wide uppercase shadow-sm" style="background: linear-gradient(135deg, #1d345d, #2d5287); color: #d1d4df" x-text="msg.date"></span>
                                </div>
                            </template>
                            {{-- Message bubble --}}
                            <div class="flex mb-1" :class="msg.is_mine ? 'justify-end' : 'justify-start'">
                                <div class="max-w-[75%] lg:max-w-[60%] rounded-2xl px-4 py-2.5 shadow-sm relative"
                                     :class="msg.is_mine ? 'text-white rounded-br-md' : 'bg-white text-slate-800 rounded-bl-md border border-steel-100'"
                                     :style="msg.is_mine ? 'background: linear-gradient(135deg, #1d345d, #2d5287)' : ''">
                                    <p class="text-[13px] leading-relaxed whitespace-pre-wrap break-words" x-text="msg.body"></p>
                                    <div class="flex items-center justify-end gap-1.5 mt-1">
                                        <span class="text-[10px] opacity-60" x-text="msg.time"></span>
                                        <template x-if="msg.is_mine">
                                            <svg class="w-3.5 h-3.5" :class="msg.read ? 'text-green-300' : 'opacity-40'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Typing Indicator --}}
                <div x-show="isTyping" x-transition class="px-5 pb-1" style="background: #eff6ef">
                    <div class="inline-flex items-center gap-1 px-3 py-2 rounded-xl bg-white text-steel-500 text-xs shadow-sm border border-steel-100">
                        <span class="w-1.5 h-1.5 rounded-full bg-accent-400 animate-bounce" style="animation-delay:0ms"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-accent-400 animate-bounce" style="animation-delay:150ms"></span>
                        <span class="w-1.5 h-1.5 rounded-full bg-accent-400 animate-bounce" style="animation-delay:300ms"></span>
                        <span class="ml-1" x-text="activeName + ' is typing...'"></span>
                    </div>
                </div>

                {{-- Input Bar --}}
                <div class="px-4 py-3 shrink-0 border-t" style="background: linear-gradient(180deg, #ffffff 0%, #f4f5f7 100%); border-color: #d1d4df">
                    <form @submit.prevent="send()" class="flex items-end gap-3">
                        <div class="flex-1 relative">
                            <textarea x-model="newMessage" @keydown.enter.prevent="if(!$event.shiftKey) send()"
                                      rows="1" x-ref="messageInput"
                                      @input="autoResize($event.target)"
                                      placeholder="Type a message..."
                                      class="w-full px-4 py-3 rounded-2xl border text-slate-900 placeholder-steel-400 focus:ring-2 focus:outline-none transition-all text-sm resize-none max-h-32 leading-relaxed"
                                      style="background: #eff6ef; border-color: #d1d4df; min-height:44px"
                                      onfocus="this.style.borderColor='#e7333e'; this.style.boxShadow='0 0 0 3px rgba(231,51,62,0.15)'"
                                      onblur="this.style.borderColor='#d1d4df'; this.style.boxShadow='none'"></textarea>
                        </div>
                        <button type="submit" :disabled="!newMessage.trim() || sending"
                                class="w-11 h-11 rounded-full text-white flex items-center justify-center transition-all disabled:opacity-40 disabled:cursor-not-allowed shrink-0 mb-0.5 shadow-lg hover:shadow-xl hover:-translate-y-0.5"
                                style="background: linear-gradient(135deg, #e7333e, #d41e2a)">
                            <svg x-show="!sending" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            <div x-show="sending" class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
function chatApp() {
    return {
        activeChat: null,
        activeName: '',
        activeRole: '',
        messages: [],
        newMessage: '',
        loading: false,
        sending: false,
        isTyping: false,
        searchQuery: '',
        onlineUsers: new Set(),
        pollTimer: null,
        heartbeatTimer: null,
        contactTimer: null,
        csrfToken: document.querySelector('meta[name="csrf-token"]')?.content,

        init() {
            const userId = {{ auth()->id() }};

            // ─── Echo/WebSocket (when Reverb is running) ───
            if (window.Echo) {
                window.Echo.private(`intranet.messages.${userId}`)
                    .listen('.message.received', (data) => {
                        if (data.sender_id == this.activeChat) {
                            // Avoid duplicate — check if we already have it from polling
                            if (!this.messages.find(m => m.id === data.id)) {
                                this.messages.push({
                                    id: data.id,
                                    body: data.body || data.subject,
                                    is_mine: false,
                                    sender_name: data.sender_name,
                                    time: new Date(data.created_at).toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' }),
                                    date: new Date(data.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
                                    read: false,
                                });
                                this.$nextTick(() => this.scrollToBottom());
                            }
                        } else {
                            this.incrementBadge(data.sender_id);
                        }
                        this.playSound();
                    });

                window.Echo.join('intranet.presence')
                    .here((users) => { this.onlineUsers = new Set(users.map(u => u.id)); })
                    .joining((user) => { this.onlineUsers.add(user.id); this.onlineUsers = new Set(this.onlineUsers); })
                    .leaving((user) => { this.onlineUsers.delete(user.id); this.onlineUsers = new Set(this.onlineUsers); });
            }

            // ─── Heartbeat Polling (always active) ───
            this.sendHeartbeat();
            this.heartbeatTimer = setInterval(() => this.sendHeartbeat(), 10000);

            // ─── Contact Refresh (every 15s) ───
            this.contactTimer = setInterval(() => this.refreshContacts(), 15000);
        },

        // ─── Heartbeat: POST to update last_seen_at, get online IDs ───
        async sendHeartbeat() {
            try {
                const res = await fetch('{{ route("intranet.chat.heartbeat") }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': this.csrfToken, 'Accept': 'application/json', 'Content-Type': 'application/json' },
                });
                const data = await res.json();
                this.onlineUsers = new Set(data.online.map(id => Number(id)));
            } catch(e) {}
        },

        // ─── Poll for new messages (efficient: only after last known ID) ───
        startPolling() {
            this.stopPolling();
            this.pollTimer = setInterval(() => this.pollNewMessages(), 3000);
        },

        stopPolling() {
            if (this.pollTimer) { clearInterval(this.pollTimer); this.pollTimer = null; }
        },

        async pollNewMessages() {
            if (!this.activeChat) return;
            const lastId = this.messages.length > 0
                ? Math.max(...this.messages.map(m => m.id))
                : 0;
            try {
                const res = await fetch(`/intranet/chat/poll/${this.activeChat}?after=${lastId}`);
                const newMsgs = await res.json();
                if (newMsgs.length > 0) {
                    // Filter out duplicates (our own sent messages already shown)
                    const existingIds = new Set(this.messages.map(m => m.id));
                    let added = false;
                    newMsgs.forEach(msg => {
                        if (!existingIds.has(msg.id)) {
                            this.messages.push(msg);
                            added = true;
                        }
                    });
                    if (added) {
                        this.$nextTick(() => this.scrollToBottom());
                        // Play sound only for incoming messages (not our own)
                        const incomingNew = newMsgs.filter(m => !m.is_mine && !existingIds.has(m.id));
                        if (incomingNew.length > 0) this.playSound();
                    }
                }
            } catch(e) {}
        },

        // ─── Refresh contact sidebar ───
        async refreshContacts() {
            try {
                const res = await fetch('{{ route("intranet.chat.contacts") }}');
                const contacts = await res.json();
                contacts.forEach(c => {
                    // Update badge count for contacts not currently active
                    if (c.id !== this.activeChat) {
                        const badge = document.getElementById(`badge-${c.id}`);
                        if (badge) {
                            if (c.unread > 0) {
                                badge.textContent = c.unread;
                                badge.classList.remove('hidden');
                            } else {
                                badge.classList.add('hidden');
                            }
                        }
                    }
                });
            } catch(e) {}
        },

        // ─── Open a chat conversation ───
        async openChat(userId, name, role) {
            this.activeChat = userId;
            this.activeName = name;
            this.activeRole = role;
            this.messages = [];
            this.loading = true;
            this.newMessage = '';

            try {
                const res = await fetch(`/intranet/chat/messages/${userId}`);
                this.messages = await res.json();
            } catch (e) {
                console.error('Failed to load messages', e);
            }

            this.loading = false;
            this.$nextTick(() => {
                this.scrollToBottom();
                this.$refs.messageInput?.focus();
            });

            // Clear badge
            const badge = document.getElementById(`badge-${userId}`);
            if (badge) badge.classList.add('hidden');

            // Start polling for this conversation
            this.startPolling();
        },

        closeChat() {
            this.activeChat = null;
            this.stopPolling();
        },

        async send() {
            const body = this.newMessage.trim();
            if (!body || this.sending) return;

            this.sending = true;
            const tempMsg = {
                id: Date.now(),
                body: body,
                is_mine: true,
                sender_name: 'You',
                time: new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' }),
                date: new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
                read: false,
                _temp: true,
            };

            this.messages.push(tempMsg);
            this.newMessage = '';
            this.$nextTick(() => this.scrollToBottom());

            // Reset textarea height
            if (this.$refs.messageInput) {
                this.$refs.messageInput.style.height = '44px';
            }

            try {
                const res = await fetch('{{ route("intranet.chat.send") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({ to_user_id: this.activeChat, body: body }),
                });

                const data = await res.json();
                // Replace temp message with real server data
                const idx = this.messages.findIndex(m => m.id === tempMsg.id);
                if (idx !== -1) this.messages[idx] = data;
            } catch (e) {
                console.error('Failed to send', e);
            }

            this.sending = false;
            this.$refs.messageInput?.focus();
        },

        // ─── Helpers ───
        incrementBadge(senderId) {
            const badge = document.getElementById(`badge-${senderId}`);
            if (badge) {
                badge.textContent = parseInt(badge.textContent || '0') + 1;
                badge.classList.remove('hidden');
            }
        },

        playSound() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                osc.frequency.value = 800;
                osc.type = 'sine';
                gain.gain.value = 0.08;
                osc.start();
                gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.2);
                osc.stop(ctx.currentTime + 0.2);
            } catch(e) {}
        },

        scrollToBottom() {
            const el = this.$refs.chatMessages;
            if (el) el.scrollTop = el.scrollHeight;
        },

        autoResize(el) {
            el.style.height = '44px';
            el.style.height = Math.min(el.scrollHeight, 128) + 'px';
        }
    };
}
</script>
@endpush
@endsection
