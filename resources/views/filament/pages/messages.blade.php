<x-filament-panels::page>
    <style>
        /* Remove Filament page padding and prevent outer scroll */
        .fi-page > .fi-page-content { padding: 0 !important; }
        .fi-main { overflow: hidden !important; }
    </style>
    <div x-data="adminChat()" x-init="init()" class="flex overflow-hidden" style="height: calc(100vh - 4rem); margin: -1.5rem;">

        {{-- ═══ Contact List ═══ --}}
        <div class="w-80 flex flex-col shrink-0" style="background: linear-gradient(180deg, #f7f8fa 0%, #ffffff 100%); border-right: 1px solid #e2e5ed;">
            {{-- Header --}}
            <div class="p-3" style="background: linear-gradient(135deg, #1d345d 0%, #0f1c33 100%); border-bottom: 1px solid rgba(255,255,255,0.08);">
                <div class="relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input type="text" x-model="searchQuery" placeholder="Search contacts..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl text-white placeholder-gray-400 text-sm transition-all border-0"
                           style="background: rgba(255,255,255,0.1); outline: none;"
                           onfocus="this.style.background='rgba(255,255,255,0.18)'; this.style.boxShadow='0 0 0 2px rgba(255,255,255,0.15)'"
                           onblur="this.style.background='rgba(255,255,255,0.1)'; this.style.boxShadow='none'">
                </div>
            </div>

            {{-- Contacts --}}
            <div class="flex-1 overflow-y-auto">
                <template x-for="contact in filteredContacts" :key="contact.id">
                    <button @click="openChat(contact)"
                            :class="activeChat === contact.id ? 'border-l-4' : 'border-l-4 border-l-transparent'"
                            :style="activeChat === contact.id ? 'background: #eff6ef; border-left-color: #e7333e' : ''"
                            class="w-full flex items-center gap-3 px-3 py-3.5 hover:bg-gray-50 transition-all text-left border-b border-gray-100">
                        <div class="relative shrink-0">
                            <div class="w-11 h-11 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-md"
                                 :style="activeChat === contact.id ? 'background: linear-gradient(135deg, #e7333e, #d41e2a)' : 'background: linear-gradient(135deg, #1d345d, #2d5287)'"
                                 x-text="contact.initial"></div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-3 h-3 rounded-full border-2 border-white transition-colors"
                                  :style="onlineUsers.has(contact.id) ? 'background-color: #22c55e' : 'background-color: #9298af'"></span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center justify-between">
                                <span class="font-semibold text-sm truncate" :style="activeChat === contact.id ? 'color: #1d345d' : 'color: #3a3d4d'" x-text="contact.name"></span>
                                <span class="text-[10px] shrink-0 ml-1" style="color: #9298af" x-text="contact.last_message_time || ''"></span>
                            </div>
                            <div class="flex items-center justify-between mt-0.5">
                                <p class="text-xs truncate" style="color: #9298af" x-text="contact.last_message || 'No messages yet'"></p>
                                <template x-if="contact.unread > 0">
                                    <span class="shrink-0 ml-1 w-5 h-5 rounded-full text-white text-[10px] font-bold flex items-center justify-center shadow-sm"
                                          style="background: linear-gradient(135deg, #e7333e, #d41e2a); box-shadow: 0 2px 6px rgba(231,51,62,0.3)"
                                          x-text="contact.unread"></span>
                                </template>
                            </div>
                        </div>
                    </button>
                </template>
            </div>
        </div>

        {{-- ═══ Chat Panel ═══ --}}
        <div class="flex-1 flex flex-col" style="background: #eff6ef">
            {{-- Empty State --}}
            <template x-if="!activeChat">
                <div class="flex-1 flex items-center justify-center" style="background: linear-gradient(180deg, #eff6ef 0%, #e4ede4 50%, #eff6ef 100%)">
                    <div class="text-center">
                        <div class="w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-5" style="background: rgba(29,52,93,0.08); border: 2px solid rgba(29,52,93,0.12)">
                            <svg class="w-10 h-10" style="color: #9298af" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        </div>
                        <h3 class="font-bold text-lg mb-2" style="color: #1d345d">Admin Messenger</h3>
                        <p class="text-sm max-w-xs" style="color: #9298af">Select a contact to manage conversations.<br>Messages are delivered in real-time.</p>
                    </div>
                </div>
            </template>

            {{-- Active Chat --}}
            <template x-if="activeChat">
                <div class="flex flex-col h-full">
                    {{-- Header --}}
                    <div class="px-5 py-3 flex items-center gap-3 shrink-0 shadow-md" style="background: linear-gradient(135deg, #1d345d 0%, #2d5287 100%)">
                        <div class="relative">
                            <div class="w-10 h-10 rounded-full flex items-center justify-center text-white font-bold text-xs shadow-md" style="background: linear-gradient(135deg, #e7333e, #d41e2a)" x-text="activeName?.charAt(0)"></div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 rounded-full border-2 transition-colors" style="border-color: #1d345d"
                                  :style="'border-color: #1d345d; background-color:' + (onlineUsers.has(activeChat) ? '#22c55e' : '#9298af')"></span>
                        </div>
                        <div class="flex-1">
                            <p class="text-white font-semibold text-sm" x-text="activeName"></p>
                            <p class="text-xs" style="color: #9298af">
                                <span x-show="onlineUsers.has(activeChat)" class="inline-flex items-center gap-1 font-medium" style="color: #4ade80">
                                    <span class="w-1.5 h-1.5 rounded-full animate-pulse" style="background: #4ade80"></span> Online
                                </span>
                                <span x-show="!onlineUsers.has(activeChat)" x-text="activeRole + (activeDept ? ' · ' + activeDept : '')"></span>
                            </p>
                        </div>
                    </div>

                    {{-- Messages --}}
                    <div class="flex-1 overflow-y-auto px-5 py-4 space-y-1" x-ref="chatPanel"
                         style="background: linear-gradient(180deg, #eff6ef 0%, #deedde 40%, #eff6ef 100%); background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 width=%2760%27 height=%2760%27 viewBox=%270 0 60 60%27%3E%3Cg fill=%27none%27 stroke=%27%239298af%27 stroke-width=%270.3%27 opacity=%270.12%27%3E%3Cpath d=%27M0 30h60M30 0v60%27/%3E%3C/g%3E%3C/svg%3E')">
                        <template x-if="loading">
                            <div class="flex items-center justify-center py-20">
                                <div class="w-8 h-8 border-2 border-t-transparent rounded-full animate-spin" style="border-color: #e7333e; border-top-color: transparent"></div>
                            </div>
                        </template>
                        <template x-if="!loading && messages.length === 0">
                            <div class="text-center py-16">
                                <div class="w-16 h-16 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-md" style="background: linear-gradient(135deg, #1d345d, #2d5287)">
                                    <svg class="w-8 h-8 text-white/70" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"/></svg>
                                </div>
                                <p class="text-sm font-medium" style="color: #747b94">No messages yet. Start a conversation below. 👋</p>
                            </div>
                        </template>
                        <template x-for="(msg, idx) in messages" :key="msg.id">
                            <div>
                                <template x-if="idx === 0 || messages[idx-1]?.date !== msg.date">
                                    <div class="flex items-center justify-center my-4">
                                        <span class="px-4 py-1.5 rounded-full text-[10px] font-semibold tracking-wide uppercase shadow-sm" style="background: linear-gradient(135deg, #1d345d, #2d5287); color: #d1d4df" x-text="msg.date"></span>
                                    </div>
                                </template>
                                <div class="flex mb-1" :class="msg.is_mine ? 'justify-end' : 'justify-start'">
                                    <div class="max-w-[70%] rounded-2xl px-4 py-2.5 shadow-sm"
                                         :class="msg.is_mine ? 'text-white rounded-br-md' : 'rounded-bl-md'"
                                         :style="msg.is_mine ? 'background: linear-gradient(135deg, #1d345d, #2d5287)' : 'background: #ffffff; color: #3a3d4d; border: 1px solid #e2e5ed'">
                                        <p class="text-[13px] leading-relaxed whitespace-pre-wrap break-words" x-text="msg.body"></p>
                                        <div class="flex items-center justify-end gap-1 mt-1">
                                            <span class="text-[10px] opacity-60" x-text="msg.time"></span>
                                            <template x-if="msg.is_mine">
                                                <svg class="w-3 h-3" :class="msg.read ? 'text-green-300' : 'opacity-40'" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Input --}}
                    <div class="px-4 py-3 shrink-0" style="background: linear-gradient(180deg, #ffffff 0%, #f7f8fa 100%); border-top: 1px solid #e2e5ed">
                        <div class="flex items-end gap-3">
                            <textarea x-model="newMessage" x-ref="msgInput"
                                      @keydown.enter.prevent="if(!$event.shiftKey) sendMsg()"
                                      @input="$event.target.style.height='40px';$event.target.style.height=Math.min($event.target.scrollHeight,120)+'px'"
                                      rows="1" placeholder="Type a message..."
                                      class="flex-1 px-4 py-2.5 rounded-xl text-sm resize-none focus:outline-none focus:ring-2 transition-all"
                                      style="background: #eff6ef; border: 1px solid #d1d4df; color: #3a3d4d; min-height:40px; max-height:120px"
                                      onfocus="this.style.borderColor='#e7333e'; this.style.boxShadow='0 0 0 3px rgba(231,51,62,0.12)'"
                                      onblur="this.style.borderColor='#d1d4df'; this.style.boxShadow='none'"></textarea>
                            <button @click="sendMsg()" :disabled="!newMessage.trim() || sending"
                                    class="w-10 h-10 rounded-full text-white flex items-center justify-center transition-all disabled:opacity-40 shrink-0 mb-0.5 shadow-lg hover:shadow-xl hover:-translate-y-0.5"
                                    style="background: linear-gradient(135deg, #e7333e, #d41e2a)">
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
