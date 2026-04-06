{{-- Echo + Pusher for Filament Admin Panel --}}
<script src="https://cdn.jsdelivr.net/npm/pusher-js@8.4.0/dist/web/pusher.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo@1.16.1/dist/echo.iife.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Echo for admin panel
        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: '{{ env("REVERB_APP_KEY") }}',
            wsHost: '{{ env("REVERB_HOST", "localhost") }}',
            wsPort: {{ env("REVERB_PORT", 8080) }},
            wssPort: {{ env("REVERB_PORT", 443) }},
            forceTLS: {{ env("REVERB_SCHEME", "http") === "https" ? "true" : "false" }},
            enabledTransports: ['ws', 'wss'],
        });

        const userId = {{ auth()->id() ?? 'null' }};
        if (!userId) return;

        // Join presence channel so employees can see admin is online
        window.Echo.join('intranet.presence')
            .here((users) => {
                console.log('[Filament Echo] Online users:', users.length);
            })
            .joining((user) => {
                console.log('[Filament Echo] User joined:', user.name);
            })
            .leaving((user) => {
                console.log('[Filament Echo] User left:', user.name);
            });

        // Listen for incoming messages on admin's private channel
        window.Echo.private(`intranet.messages.${userId}`)
            .listen('.message.received', (data) => {
                console.log('[Filament Echo] New message from:', data.sender_name);

                // Show browser notification
                if (Notification.permission === 'granted') {
                    new Notification('New Message', {
                        body: `${data.sender_name}: ${data.body || data.subject}`,
                        icon: '/favicon.ico',
                    });
                } else if (Notification.permission !== 'denied') {
                    Notification.requestPermission();
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
                    gain.gain.value = 0.08;
                    osc.start();
                    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.2);
                    osc.stop(ctx.currentTime + 0.2);
                } catch(e) {}

                // Refresh the Filament badge count by dispatching a Livewire event
                if (window.Livewire) {
                    // Force navigation badge refresh
                    window.Livewire.dispatch('$refresh');
                }
            });

        console.log('[Filament Echo] Connected to Reverb WebSocket');
    });
</script>
