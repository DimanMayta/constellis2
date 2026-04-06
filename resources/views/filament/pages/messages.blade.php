<x-filament-panels::page>
    <div x-data="adminChat()" x-init="init()" class="h-[calc(100vh-180px)] flex rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900">

        {{-- ═══ Contact List ═══ --}}
        <div class="w-80 border-r border-gray-200 dark:border-gray-700 flex flex-col shrink-0 bg-gray-50 dark:bg-gray-800">
            {{-- Search --}}
            <div class="p-3 border-b border-gray-200 dark:border-gray-700">
                <input type="text" x-model="searchQuery" placeholder="Search contacts..."
                       class="w-full px-3 py-2 rounded-lg bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-600 text-sm text-gray-900 dark:text-gray-100 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
            </div>

            {{-- Contacts --}}
            <div class="flex-1 overflow-y-auto">
                <template x-for="contact in filteredContacts" :key="contact.id">
                    <button @click="openChat(contact)"
                            :class="activeChat === contact.id ? 'bg-primary-50 dark:bg-primary-900/30 border-l-4 border-l-primary-500' : 'border-l-4 border-l-transparent'"
                            class="w-full flex items-center gap-3 px-3 py-3 hover:bg-gray-100 dark:hover:bg-gray-700/50 transition-colors text-left border-b border-gray-100 dark:border-gray-700">
                        <div class="relative shrink-0">
                            <div class="w-10 h-10 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-xs" x-text="contact.initial"></div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white dark:border-gray-800 transition-colors"
                                  :style="onlineUsers.has(contact.id) ? 'background-color: #22c55e' : 'background-color: #d1d5db'"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-900 dark:text-gray-100 font-semibold text-sm truncate" x-text="contact.name"></span>
                                <span class="text-gray-400 text-[10px] shrink-0 ml-1" x-text="contact.last_message_time || ''"></span>
                            </div>
                            <div class="flex items-center justify-between mt-0.5">
                                <p class="text-gray-400 dark:text-gray-500 text-xs truncate" x-text="contact.last_message || 'No messages yet'"></p>
                                <template x-if="contact.unread > 0">
                                    <span class="shrink-0 ml-1 w-5 h-5 rounded-full bg-primary-500 text-white text-[10px] font-bold flex items-center justify-center" x-text="contact.unread"></span>
                                </template>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        {{-- ═══ Chat Panel ═══ --}}
        <div class="flex-1 flex flex-col">
            {{-- Empty State --}}
            <template x-if="!activeChat">
                <div class="flex-1 flex items-center justify-center">
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-full bg-gray-100 dark:bg-gray-800 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-10 h-10 text-gray-300 dark:text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="text-gray-900 dark:text-gray-100 font-bold text-lg mb-1">Admin Messenger</h3>
                        <p class="text-gray-400 dark:text-gray-500 text-sm">Select a contact to manage conversations</p>
                    </div>
                </div>
            </template>

            {{-- Active Chat --}}
            <template x-if="activeChat">
                <div class="flex flex-col h-full">
                    {{-- Header with Online Presence --}}
                    <div class="px-5 py-3 border-b border-gray-200 dark:border-gray-700 flex items-center gap-3 bg-white dark:bg-gray-900 shrink-0">
                        <div class="relative">
                            <div class="w-9 h-9 rounded-full bg-primary-500 flex items-center justify-center text-white font-bold text-xs" x-text="activeName?.charAt(0)"></div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full border-2 border-white dark:border-gray-900 transition-colors"
                                  :style="onlineUsers.has(activeChat) ? 'background-color: #22c55e' : 'background-color: #d1d5db'"></span>
                        </div>
                        <div class="flex-1">
                            <p class="text-gray-900 dark:text-gray-100 font-semibold text-sm" x-text="activeName"></p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                <span x-show="onlineUsers.has(activeChat)" class="inline-flex items-center gap-1 font-medium" style="color: #22c55e;">
                                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background-color: #22c55e;"></span> Online
                                </span>
                                <span x-show="!onlineUsers.has(activeChat)" x-text="activeRole + (activeDept ? ' · ' + activeDept : '')"></span>
                            </p>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div class="flex-1 overflow-y-auto px-5 py-4 space-y-1 bg-gray-50 dark:bg-gray-800/50" x-ref="chatPanel">
                        <template x-if="loading">
                            <div class="flex items-center justify-center py-20">
                                <x-filament::loading-indicator class="h-6 w-6" />
                            </div>
                        </template>
                        <template x-if="!loading && messages.length === 0">
                            <div class="text-center py-16">
                                <p class="text-gray-400 text-sm">No messages yet. Start a conversation below.</p>
                            </div>
                        </template>
                        <template x-for="(msg, idx) in messages" :key="msg.id">
                            <div>
                                <template x-if="idx === 0 || messages[idx-1]?.date !== msg.date">
                                    <div class="flex items-center justify-center my-3">
                                        <span class="px-3 py-1 rounded-full bg-white dark:bg-gray-700 text-gray-400 text-[10px] font-medium shadow-sm" x-text="msg.date"></span>
                                    </div>
                                </template>
                                <div class="flex mb-1" :class="msg.is_mine ? 'justify-end' : 'justify-start'">
                                    <div class="max-w-[70%] rounded-2xl px-4 py-2.5 shadow-sm"
                                         :class="msg.is_mine ? 'bg-primary-500 text-white rounded-br-md' : 'bg-white dark:bg-gray-700 text-gray-800 dark:text-gray-200 rounded-bl-md'">
                                        <p class="text-[13px] leading-relaxed whitespace-pre-wrap break-words" x-text="msg.body"></p>
                                        <div class="flex items-center justify-end gap-1 mt-1">
                                            <span class="text-[10px] opacity-60" x-text="msg.time"></span>
                                            <template x-if="msg.is_mine">
                                                <svg class="w-3 h-3" :class="msg.read ? 'text-sky-200' : 'opacity-40'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Input --}}
                    <div class="px-4 py-3 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-700 shrink-0">
                        <div class="flex items-end gap-3">
                            <textarea x-model="newMessage" x-ref="msgInput"
                                      @keydown.enter.prevent="if(!$event.shiftKey) sendMsg()"
                                      @input="$event.target.style.height='40px';$event.target.style.height=Math.min($event.target.scrollHeight,120)+'px'"
                                      rows="1" placeholder="Type a message..."
                                      class="flex-1 px-4 py-2.5 rounded-xl bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-gray-600 text-gray-900 dark:text-gray-100 placeholder-gray-400 text-sm focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 resize-none"
                                      style="min-height:40px;max-height:120px"></textarea>
                            <button @click="sendMsg()" :disabled="!newMessage.trim() || sending"
                                    class="w-10 h-10 rounded-full bg-primary-500 text-white flex items-center justify-center hover:bg-primary-600 transition-colors disabled:opacity-40 shrink-0 mb-0.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>

    <script>
    function adminChat() {
        return {
            contacts: @json($this->getContacts()),
            activeChat: null,
            activeName: '',
            activeRole: '',
            activeDept: '',
            messages: [],
            newMessage: '',
            loading: false,
            sending: false,
            searchQuery: '',
            onlineUsers: new Set(),
            pollTimer: null,
            heartbeatTimer: null,

            get filteredContacts() {
                if (!this.searchQuery) return this.contacts;
                const q = this.searchQuery.toLowerCase();
                return this.contacts.filter(c => c.name.toLowerCase().includes(q));
            },

            init() {
                // ─── Heartbeat: update last_seen_at, get online users ───
                this.sendHeartbeat();
                this.heartbeatTimer = setInterval(() => this.sendHeartbeat(), 10000);
            },

            async sendHeartbeat() {
                try {
                    const res = await fetch('/intranet/chat/heartbeat', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content
                                || '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                        },
                    });
                    const data = await res.json();
                    this.onlineUsers = new Set(data.online.map(id => Number(id)));
                } catch(e) {}
            },

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
                        const existingIds = new Set(this.messages.map(m => m.id));
                        let added = false;
                        newMsgs.forEach(msg => {
                            if (!existingIds.has(msg.id)) {
                                this.messages.push(msg);
                                added = true;
                            }
                        });
                        if (added) {
                            this.$nextTick(() => {
                                const panel = this.$refs.chatPanel;
                                if (panel) panel.scrollTop = panel.scrollHeight;
                            });
                            const incomingNew = newMsgs.filter(m => !m.is_mine && !existingIds.has(m.id));
                            if (incomingNew.length > 0) this.playSound();
                        }
                    }
                } catch(e) {}
            },

            async openChat(contact) {
                this.activeChat = contact.id;
                this.activeName = contact.name;
                this.activeRole = contact.role;
                this.activeDept = contact.department || '';
                this.loading = true;

                try {
                    const result = await this.$wire.fetchMessages(contact.id);
                    this.messages = result;
                    contact.unread = 0;
                } catch(e) {
                    console.error('Failed to load', e);
                }

                this.loading = false;
                this.$nextTick(() => {
                    const panel = this.$refs.chatPanel;
                    if (panel) panel.scrollTop = panel.scrollHeight;
                    this.$refs.msgInput?.focus();
                });

                // Start fast polling
                this.startPolling();
            },

            async sendMsg() {
                const body = this.newMessage.trim();
                if (!body || this.sending) return;

                this.sending = true;
                const tempId = Date.now();
                this.messages.push({
                    id: tempId, body, is_mine: true, sender_name: 'You',
                    time: new Date().toLocaleTimeString('en-US', { hour: 'numeric', minute: '2-digit' }),
                    date: new Date().toLocaleDateString('en-US', { month: 'short', day: 'numeric' }),
                    read: false,
                });
                this.newMessage = '';
                this.$nextTick(() => {
                    const panel = this.$refs.chatPanel;
                    if (panel) panel.scrollTop = panel.scrollHeight;
                    if (this.$refs.msgInput) this.$refs.msgInput.style.height = '40px';
                });

                try {
                    const result = await this.$wire.sendReply(this.activeChat, body);
                    const idx = this.messages.findIndex(m => m.id === tempId);
                    if (idx !== -1) this.messages[idx] = result;
                } catch(e) {
                    console.error('Send failed:', e);
                }

                this.sending = false;
                this.$refs.msgInput?.focus();
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
        };
    }
    </script>
</x-filament-panels::page>
