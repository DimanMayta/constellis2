@extends('layouts.app')
@section('title', 'Contact Us — Constellis')
@section('content')

<section class="relative py-28 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">Get In Touch</span>
        <h1 class="section-heading-white mb-6">Contact Us</h1>
        <p class="section-subheading-white">Ready to discuss your security needs? Our team is here to help.</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 80" fill="none" class="w-full"><path d="M0,80 L0,40 Q360,0 720,40 Q1080,80 1440,30 L1440,80 Z" fill="white"/></svg></div>
</section>

<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-5 gap-12">
            <div class="lg:col-span-3">
                @if(session('success'))
                    <div class="card p-6 mb-8 border-green-200 bg-green-50">
                        <div class="flex items-center gap-3">
                            <svg class="w-6 h-6 text-green-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="text-green-800 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6" id="contact-form">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-slate-700 text-sm font-semibold mb-2">Full Name *</label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="Your name">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-slate-700 text-sm font-semibold mb-2">Email *</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="you@company.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-slate-700 text-sm font-semibold mb-2">Phone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="+1 (555) 000-0000">
                        </div>
                        <div>
                            <label for="company" class="block text-slate-700 text-sm font-semibold mb-2">Company</label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="Your company">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-slate-700 text-sm font-semibold mb-2">Subject *</label>
                        <input type="text" id="subject" name="subject" required value="{{ old('subject') }}"
                               class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="How can we help?">
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="message" class="block text-slate-700 text-sm font-semibold mb-2">Message *</label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none" placeholder="Tell us about your requirements...">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full sm:w-auto">
                        Send Message
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 space-y-6">
                <div class="card p-6">
                    <h3 class="text-slate-900 font-display font-semibold text-lg mb-6">Headquarters</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-3 text-slate-500">
                            <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                            <span class="text-sm">12018 Sunrise Valley Drive<br>Suite 140, Reston, VA 20191</span>
                        </li>
                        <li><a href="tel:18663491506" class="flex items-center gap-3 text-slate-500 hover:text-blue-600 transition-colors text-sm"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>+1 866 349 1506</a></li>
                        <li><a href="mailto:info@constellis.com" class="flex items-center gap-3 text-slate-500 hover:text-blue-600 transition-colors text-sm"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>info@constellis.com</a></li>
                    </ul>
                </div>
                @forelse($offices ?? [] as $office)
                    <div class="card p-6">
                        <h3 class="text-slate-900 font-display font-semibold text-base mb-4">{{ $office->name }}</h3>
                        <p class="text-slate-500 text-sm">{{ $office->address }}</p>
                        @if($office->phone)<a href="tel:{{ preg_replace('/[^0-9+]/', '', $office->phone) }}" class="text-blue-600 text-sm mt-2 block font-medium">{{ $office->phone }}</a>@endif
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- Satisfaction Survey --}}
<section class="py-16 bg-slate-50" x-data="surveyWidget()">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
        @if(session('survey_success'))
            <div class="card p-8 text-center border-green-200 bg-green-50">
                <svg class="w-12 h-12 text-green-500 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <h3 class="text-lg font-display font-bold text-green-800 mb-2">Thank You!</h3>
                <p class="text-green-700 text-sm">{{ session('survey_success') }}</p>
            </div>
        @else
            <div class="card p-8 sm:p-10">
                <div class="text-center mb-8">
                    <span class="text-blue-600 text-sm font-bold tracking-wider uppercase mb-2 block">Your Feedback Matters</span>
                    <h2 class="text-2xl font-display font-bold text-slate-900 mb-2">How was your experience?</h2>
                    <p class="text-slate-400 text-sm">Help us improve by rating your visit</p>
                </div>

                <form action="{{ route('survey.store') }}" method="POST" class="space-y-6">
                    @csrf

                    {{-- Star Ratings --}}
                    <div class="grid sm:grid-cols-2 gap-6">
                        @foreach([
                            ['overall_rating', 'Overall Experience', true],
                            ['design_rating', 'Website Design', false],
                            ['usability_rating', 'Ease of Use', false],
                            ['content_rating', 'Content Quality', false],
                        ] as $rating)
                            <div>
                                <label class="block text-slate-700 text-sm font-semibold mb-2">{{ $rating[1] }} {{ $rating[2] ? '*' : '' }}</label>
                                <div class="flex gap-1">
                                    @for($s = 1; $s <= 5; $s++)
                                        <label class="cursor-pointer">
                                            <input type="radio" name="{{ $rating[0] }}" value="{{ $s }}" class="sr-only peer" {{ $rating[2] ? ($s == 5 ? '' : '') : '' }}>
                                            <svg class="w-8 h-8 text-slate-200 peer-checked:text-amber-400 hover:text-amber-300 transition-colors" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        </label>
                                    @endfor
                                </div>
                                @error($rating[0]) <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        @endforeach
                    </div>

                    {{-- Would Recommend --}}
                    <div>
                        <label class="block text-slate-700 text-sm font-semibold mb-3">Would you recommend Constellis?</label>
                        <div class="flex gap-3">
                            <label class="cursor-pointer"><input type="radio" name="would_recommend" value="1" class="sr-only peer"><span class="px-6 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 peer-checked:border-green-500 peer-checked:bg-green-50 peer-checked:text-green-700 transition-all block">👍 Yes</span></label>
                            <label class="cursor-pointer"><input type="radio" name="would_recommend" value="0" class="sr-only peer"><span class="px-6 py-2.5 rounded-xl border border-slate-200 text-sm font-medium text-slate-600 peer-checked:border-red-500 peer-checked:bg-red-50 peer-checked:text-red-700 transition-all block">👎 No</span></label>
                        </div>
                    </div>

                    <div class="divider-gradient"></div>

                    {{-- Optional Details --}}
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label for="survey_name" class="block text-slate-700 text-sm font-semibold mb-2">Name (optional)</label>
                            <input type="text" id="survey_name" name="visitor_name"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all text-sm" placeholder="Your name">
                        </div>
                        <div>
                            <label for="survey_email" class="block text-slate-700 text-sm font-semibold mb-2">Email (optional)</label>
                            <input type="email" id="survey_email" name="visitor_email"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all text-sm" placeholder="you@email.com">
                        </div>
                    </div>
                    <div>
                        <label for="suggestions" class="block text-slate-700 text-sm font-semibold mb-2">Suggestions (optional)</label>
                        <textarea id="suggestions" name="suggestions" rows="3"
                                  class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:outline-none transition-all resize-none text-sm" placeholder="How can we improve?"></textarea>
                    </div>

                    <button type="submit" class="btn-primary w-full">Submit Feedback</button>
                </form>
            </div>
        @endif
    </div>
</section>
@endsection

