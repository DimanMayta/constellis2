@extends('layouts.app')
@section('title', 'Apply — ' . $job->title . ' — Constellis')

@section('content')
<section class="relative py-20 overflow-hidden -mt-20 pt-40 bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <a href="{{ route('jobs.show', $job) }}" class="inline-flex items-center gap-2 text-blue-200 hover:text-white text-sm font-medium mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Position
        </a>
        <h1 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">Apply for {{ $job->title }}</h1>
        <p class="text-blue-200">{{ $job->location }} · {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="none" class="w-full"><path d="M0,60 L0,30 Q720,0 1440,30 L1440,60 Z" fill="white"/></svg></div>
</section>

<section class="py-16 bg-white">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="card p-8 sm:p-10">
            <form action="{{ route('jobs.submit', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Step 1: Personal Info --}}
                <div>
                    <h3 class="text-lg font-display font-bold text-slate-900 mb-1">Personal Information</h3>
                    <p class="text-slate-400 text-sm mb-6">Required fields are marked with *</p>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="full_name" class="block text-slate-700 text-sm font-semibold mb-2">Full Name *</label>
                            <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="Your full name">
                            @error('full_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-slate-700 text-sm font-semibold mb-2">Email *</label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="you@example.com">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="phone" class="block text-slate-700 text-sm font-semibold mb-2">Phone</label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="+1 (555) 000-0000">
                        </div>
                    </div>
                </div>

                <div class="divider-gradient"></div>

                {{-- Step 2: Documents --}}
                <div>
                    <h3 class="text-lg font-display font-bold text-slate-900 mb-1">Required Documents</h3>
                    <p class="text-slate-400 text-sm mb-6">Upload your documents (PDF, DOC, DOCX — max 10MB each)</p>
                    <div class="space-y-5">
                        <div>
                            <label for="cv" class="block text-slate-700 text-sm font-semibold mb-2">Curriculum Vitae (CV) *</label>
                            <input type="file" id="cv" name="cv" required accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold file:text-sm hover:file:bg-blue-100 transition-all">
                            @error('cv') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nda" class="block text-slate-700 text-sm font-semibold mb-2">Non-Disclosure Agreement (NDA)</label>
                            <input type="file" id="nda" name="nda" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold file:text-sm hover:file:bg-blue-100 transition-all">
                        </div>
                        <div>
                            <label for="interview_request" class="block text-slate-700 text-sm font-semibold mb-2">Interview Request</label>
                            <input type="file" id="interview_request" name="interview_request" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold file:text-sm hover:file:bg-blue-100 transition-all">
                        </div>
                        <div>
                            <label for="application_form" class="block text-slate-700 text-sm font-semibold mb-2">Application Form</label>
                            <input type="file" id="application_form" name="application_form" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-blue-50 file:text-blue-700 file:font-semibold file:text-sm hover:file:bg-blue-100 transition-all">
                        </div>
                    </div>
                </div>

                <div class="divider-gradient"></div>

                {{-- Step 3: Experience --}}
                <div>
                    <h3 class="text-lg font-display font-bold text-slate-900 mb-1">Additional Information</h3>
                    <p class="text-slate-400 text-sm mb-6">Tell us about your relevant experience</p>
                    <div class="space-y-5">
                        <div>
                            <label for="experience_summary" class="block text-slate-700 text-sm font-semibold mb-2">Experience Summary</label>
                            <textarea id="experience_summary" name="experience_summary" rows="4"
                                      class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none"
                                      placeholder="Briefly describe your relevant experience...">{{ old('experience_summary') }}</textarea>
                        </div>
                        <div>
                            <label for="cover_letter" class="block text-slate-700 text-sm font-semibold mb-2">Cover Letter</label>
                            <textarea id="cover_letter" name="cover_letter" rows="4"
                                      class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none"
                                      placeholder="Why are you interested in this position?">{{ old('cover_letter') }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-primary w-full py-4 text-base">
                    Submit Application
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
