@extends('layouts.app')
@section('title', 'Training — Constellis')
@section('content')
<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Training Center</span>
        <h1 class="section-heading-white mb-6">Advanced Training</h1>
        <p class="section-subheading-white">World-class programs for security, military, and law enforcement professionals.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @forelse($categories ?? [] as $i => $category)
            <div class="mb-16" id="{{ $category->anchor_id ?? Str::slug($category->name) }}" data-animate>
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-display font-bold text-slate-900">{{ $category->name }}</h2>
                        @if($category->description)<p class="text-slate-400 text-sm mt-1">{{ $category->description }}</p>@endif
                    </div>
                </div>
                @if($category->courses->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($category->courses as $course)
                            <div class="card p-6 group">
                                <h3 class="text-slate-900 font-display font-semibold text-lg mb-2 group-hover:text-blue-600 transition-colors">{{ $course->name }}</h3>
                                <p class="text-slate-400 text-sm leading-relaxed mb-4">{{ Str::limit($course->description, 150) }}</p>
                                <div class="flex items-center gap-4 text-xs text-slate-400">
                                    @if($course->location)<span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>{{ $course->location }}</span>@endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                <div class="divider-gradient mt-12"></div>
            </div>
        @empty
            @php $fallback = ['High Threat Protection' => ['Protective Security Detail', 'Close Protection Ops', 'Motorcade Security'], 'Firearms Training' => ['Handgun Fundamentals', 'Carbine/Rifle Ops', 'Shotgun Tactical'], 'K9 Training' => ['Explosive Detection K-9', 'Narcotic Detection K-9', 'Patrol K-9 Ops']]; @endphp
            @foreach($fallback as $c => $courses)
                <div class="mb-16" data-animate>
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h2 class="text-2xl font-display font-bold text-slate-900">{{ $c }}</h2>
                    </div>
                    <div class="grid md:grid-cols-3 gap-6">
                        @foreach($courses as $name)<div class="card p-6"><h3 class="text-slate-900 font-display font-semibold text-lg">{{ $name }}</h3><p class="text-slate-400 text-sm mt-2">Professional training at our state-of-the-art facility.</p></div>@endforeach
                    </div>
                    <div class="divider-gradient mt-12"></div>
                </div>
            @endforeach
        @endforelse
    </div>
</section>
@endsection
