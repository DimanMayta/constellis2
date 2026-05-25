{{-- Supported Project Card Partial --}}
<div class="group relative bg-white/[0.04] hover:bg-white/[0.08] rounded-2xl border border-white/[0.08] hover:border-accent-500/30 transition-all duration-500 hover:-translate-y-1 overflow-hidden backdrop-blur-sm">
    {{-- Top accent line --}}
    <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-accent-500 via-red-400 to-accent-500 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>

    {{-- Logo Area --}}
    <div class="relative h-40 overflow-hidden">
        @if($project->logo)
            <img src="{{ asset('storage/' . $project->logo) }}"
                 alt="{{ $project->name_en }}"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @elseif($project->image_url)
            <img src="{{ $project->image_url }}"
                 alt="{{ $project->name_en }}"
                 class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
        @else
            <div class="w-full h-full bg-white/[0.03] flex items-center justify-center">
                <div class="w-14 h-14 rounded-2xl bg-accent-500/10 flex items-center justify-center text-accent-400 group-hover:bg-accent-500 group-hover:text-white transition-all duration-300">
                    <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                    </svg>
                </div>
            </div>
        @endif
    </div>

    {{-- Content --}}
    <div class="p-5">
        <h4 class="font-display font-bold text-base text-white mb-2 group-hover:text-accent-400 transition-colors duration-300"
            x-text="$store.lang.current === 'en' ? '{{ addslashes($project->name_en) }}' : '{{ addslashes($project->name_es) }}'">
        </h4>
        <p class="text-white/40 text-sm leading-relaxed mb-4 line-clamp-3"
           x-text="$store.lang.current === 'en' ? '{{ addslashes($project->description_en) }}' : '{{ addslashes($project->description_es) }}'">
        </p>

        @if($project->website_url)
            <a href="{{ $project->website_url }}" target="_blank" rel="noopener"
               class="inline-flex items-center gap-2 text-accent-400 hover:text-accent-300 font-bold text-sm group/link transition-colors duration-300">
                <span x-text="$store.lang.current === 'en' ? 'SUPPORT PROJECT' : 'APOYAR PROYECTO'"></span>
                <svg class="w-4 h-4 group-hover/link:translate-x-1 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        @endif
    </div>
</div>
