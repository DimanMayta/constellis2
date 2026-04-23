@php
    $record = $getRecord();
    $imgUrl = '';
    if ($record) {
        if ($record->bg_image) {
            $imgUrl = asset('storage/' . $record->bg_image);
        } else {
            $defaultImages = [
                '2 carrusel-special forces.jpg.jpeg',
                '3carrusel-shaking hands.jpg.jpeg',
                '5carrusel-help.jpg.jpeg',
                '4carrusel-ayuda medica2.jpg.jpeg',
                'carrusel7.png',
                'carrusel8.png',
                'carrusel6.png',
                'carrucel11.jpeg',
                'carrucel12.jpeg',
                'carrucel13.avif',
                'carrucel14.jpeg',
            ];
            $idx = max(0, ($record->sort_order ?? 1) - 1) % count($defaultImages);
            $imgUrl = asset('images/' . $defaultImages[$idx]);
        }
    }
    $currentPos = intval($record?->bg_position ?? 50);
    $badge = $record?->badge_en ?? 'Global Security Solutions';
    $titleA = $record?->title_a_en ?? 'Freedom Through';
    $titleB = $record?->title_b_en ?? 'Strength';
    $desc = $record?->description_en ?? '';
    $cta = $record?->cta_en ?? 'Learn More';
@endphp

@if($imgUrl)
<div x-data="{
        posY: @entangle($getStatePath()),
        dragging: false,
        sy: 0,
        sp: 0,
        init() {
            if (!this.posY && this.posY !== 0) this.posY = {{ $currentPos }};
            this.posY = parseInt(this.posY) || 50;

            const area = this.$refs.dragarea;
            const bg = this.$refs.bgimg;
            const self = this;

            area.addEventListener('mousedown', function(e) {
                self.dragging = true;
                self.sy = e.clientY;
                self.sp = self.posY;
                e.preventDefault();
                e.stopPropagation();
            });
            area.addEventListener('touchstart', function(e) {
                self.dragging = true;
                self.sy = e.touches[0].clientY;
                self.sp = self.posY;
                e.preventDefault();
                e.stopPropagation();
            }, { passive: false });

            document.addEventListener('mousemove', function(e) {
                if (!self.dragging) return;
                const d = e.clientY - self.sy;
                const h = area.offsetHeight;
                self.posY = Math.max(0, Math.min(100, Math.round(self.sp - (d / h) * 100)));
                bg.style.backgroundPosition = 'center ' + self.posY + '%';
            });
            document.addEventListener('touchmove', function(e) {
                if (!self.dragging) return;
                const d = e.touches[0].clientY - self.sy;
                const h = area.offsetHeight;
                self.posY = Math.max(0, Math.min(100, Math.round(self.sp - (d / h) * 100)));
                bg.style.backgroundPosition = 'center ' + self.posY + '%';
            }, { passive: true });

            document.addEventListener('mouseup', function() { self.dragging = false; });
            document.addEventListener('touchend', function() { self.dragging = false; });
        },
        sq(v) {
            this.posY = v;
            this.$refs.bgimg.style.backgroundPosition = 'center ' + v + '%';
        }
    }" style="max-width:100%; width:100%; overflow:hidden; box-sizing:border-box; contain:content;">

    {{-- Header bar --}}
    <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:12px;">
        <label style="font-size:15px; font-weight:700; color:white; display:flex; align-items:center; gap:8px;">
            <svg style="width:22px;height:22px;color:#f59e0b;" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            Image Position Editor
        </label>
        <span style="font-size:13px; font-family:monospace; padding:5px 14px; border-radius:8px; background:rgba(245,158,11,0.15); color:#f59e0b; border:1px solid rgba(245,158,11,0.3); font-weight:600;"
              x-text="'center ' + posY + '%'"></span>
    </div>

    {{-- Full preview with simulated navbar --}}
    <div style="border-radius:0 0 12px 12px; overflow:hidden; border-left:2px solid rgba(255,255,255,0.15); border-right:2px solid rgba(255,255,255,0.15); border-bottom:2px solid rgba(255,255,255,0.15); border-top:none; box-shadow:0 4px 30px rgba(0,0,0,0.5); width:100%; max-width:100%; box-sizing:border-box;"
         :style="dragging ? 'border-color:#f59e0b; box-shadow:0 4px 30px rgba(245,158,11,0.2);' : ''">

        {{-- Simulated Navbar --}}
        <div style="background:#0f172a; padding:14px 20px; display:flex; align-items:center; gap:14px; border-bottom:2px solid rgba(255,255,255,0.15); position:relative; z-index:30; margin:0; border-top:2px solid rgba(255,255,255,0.15);">
            <img src="{{ asset('images/logo.png') }}" style="height:28px; width:auto;" onerror="this.style.display='none'" />
            <div style="display:flex; gap:10px; margin-left:auto;">
                <span style="color:rgba(255,255,255,0.6); font-size:10px; font-weight:600;">Home</span>
                <span style="color:rgba(255,255,255,0.6); font-size:10px; font-weight:600;">About Us</span>
                <span style="color:rgba(255,255,255,0.6); font-size:10px; font-weight:600;">Services</span>
                <span style="color:rgba(255,255,255,0.6); font-size:10px; font-weight:600;">Opportunities</span>
                <span style="color:rgba(255,255,255,0.6); font-size:10px; font-weight:600;">Events</span>
                <span style="color:rgba(255,255,255,0.6); font-size:10px; font-weight:600;">Clients</span>
                <span style="color:rgba(255,255,255,0.6); font-size:10px; font-weight:600;">Contact</span>
            </div>
        </div>

        {{-- Hero area (draggable) --}}
        <div x-ref="dragarea"
         style="position:relative; width:100%; height:400px; overflow:hidden; cursor:grab; user-select:none; -webkit-user-select:none;"
             :style="dragging ? 'cursor:grabbing;' : ''">

            {{-- Background image --}}
            <div x-ref="bgimg"
                 style="position:absolute; inset:0; background-image:url('{{ $imgUrl }}'); background-size:cover; background-repeat:no-repeat; background-position:center {{ $currentPos }}%; pointer-events:none; transition:none;">
            </div>

            {{-- Dark gradient overlay (same as real hero) --}}
            <div style="position:absolute; inset:0; background:linear-gradient(to right, rgba(0,0,0,0.8), rgba(0,0,0,0.5), rgba(0,0,0,0.2)); pointer-events:none;"></div>

            {{-- Real slide content --}}
            <div style="position:relative; z-index:10; display:flex; align-items:center; height:100%; max-width:700px; padding:0 40px; pointer-events:none;">
                <div>
                    {{-- Badge --}}
                    <span style="display:inline-flex; align-items:center; gap:6px; padding:6px 14px; border-radius:999px; background:rgba(239,68,68,0.15); border:1px solid rgba(239,68,68,0.25); color:#f87171; font-size:10px; font-weight:700; letter-spacing:1.5px; text-transform:uppercase; margin-bottom:16px;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#ef4444;"></span>
                        {{ $badge }}
                    </span>
                    {{-- Title --}}
                    <h1 style="font-size:48px; font-weight:800; color:white; line-height:1.08; margin:0 0 16px 0; font-family:ui-serif,Georgia,Cambria,serif;">
                        {{ $titleA }}<br>
                        <span style="color:#f87171;">{{ $titleB }}</span>
                    </h1>
                    {{-- Description --}}
                    @if($desc)
                    <p style="color:rgba(255,255,255,0.7); font-size:14px; line-height:1.6; margin:0 0 20px 0; max-width:450px;">{{ $desc }}</p>
                    @endif
                    {{-- CTA --}}
                    <div style="display:inline-flex; align-items:center; gap:8px; padding:10px 22px; border-radius:8px; background:#ef4444; color:white; font-size:13px; font-weight:700;">
                        {{ $cta }} →
                    </div>
                </div>
            </div>

            {{-- Drag instruction overlay --}}
            <div style="position:absolute; top:12px; right:12px; z-index:20; pointer-events:none; transition:opacity 0.2s;"
                 :style="dragging ? 'opacity:0;' : 'opacity:1;'">
                <div style="display:flex; align-items:center; gap:6px; padding:8px 14px; border-radius:8px; background:rgba(0,0,0,0.7); backdrop-filter:blur(8px); border:1px solid rgba(255,255,255,0.15);">
                    <svg style="width:16px;height:16px;color:rgba(255,255,255,0.8);" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                    <span style="color:rgba(255,255,255,0.9); font-size:12px; font-weight:600;">↕ Drag to reposition</span>
                </div>
            </div>

            {{-- Bottom dots (like carousel) --}}
            <div style="position:absolute; bottom:16px; left:50%; transform:translateX(-50%); z-index:10; display:flex; gap:6px; pointer-events:none;">
                @for($d = 0; $d < 7; $d++)
                <div style="width:8px; height:8px; border-radius:50%; {{ $d === 0 ? 'background:white;' : 'background:rgba(255,255,255,0.4);' }}"></div>
                @endfor
            </div>
        </div>
    </div>

    {{-- Quick position buttons --}}
    <div style="display:flex; align-items:center; gap:8px; flex-wrap:wrap; margin-top:12px;">
        <span style="font-size:12px; color:#9ca3af; margin-right:4px;">Quick:</span>
        <template x-for="b in [{l:'Bottom',v:0},{l:'Lower',v:15},{l:'Center',v:50},{l:'Upper',v:75},{l:'Top',v:100}]" :key="b.v">
            <button type="button" @click.stop.prevent="sq(b.v)"
                    :style="'padding:6px 16px; font-size:12px; border-radius:8px; font-weight:600; border:none; cursor:pointer; transition:all 0.15s;' + (Math.abs(posY - b.v) <= 10 ? 'background:#f59e0b; color:white;' : 'background:rgba(255,255,255,0.1); color:rgba(255,255,255,0.7);')"
                    x-text="b.l"></button>
        </template>
    </div>
</div>
@else
<div style="width:100%; height:200px; border-radius:12px; border:2px dashed rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; color:rgba(255,255,255,0.4); font-size:14px;">
    Save the slide first to see the position editor
</div>
@endif
