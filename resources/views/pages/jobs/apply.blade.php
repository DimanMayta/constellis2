@extends('layouts.app')
@section('title', 'Apply — ' . $job->title . ' — Constellis')

@section('content')
<section class="relative py-20 overflow-hidden bg-gradient-to-br from-[#1d345d] via-[#253d6a] to-[#1d345d]">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <a href="{{ route('jobs.show', $job) }}" class="inline-flex items-center gap-2 text-[#9298af] hover:text-white text-sm font-medium mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span x-text="$store.lang.current === 'en' ? 'Back to Position' : 'Volver al Puesto'"></span>
        </a>
        <h1 class="text-3xl md:text-4xl font-display font-bold text-white mb-2">
            <span x-text="$store.lang.current === 'en' ? 'Apply for' : 'Aplicar a'"></span> {{ $job->title }}
        </h1>
        <p class="text-[#9298af]">{{ $job->location }} · {{ ucfirst(str_replace('-', ' ', $job->employment_type)) }}</p>
    </div>
    <div class="absolute bottom-0 left-0 right-0"><svg viewBox="0 0 1440 60" fill="none" class="w-full"><path d="M0,60 L0,30 Q720,0 1440,30 L1440,60 Z" fill="#eff6ef"/></svg></div>
</section>

<section class="py-16 bg-[#eff6ef]">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white rounded-2xl p-8 sm:p-10 border border-[#9298af]/20 shadow-sm">
            <form action="{{ route('jobs.submit', $job) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                @csrf

                {{-- Step 1: Personal Info --}}
                <div>
                    <h3 class="text-lg font-display font-bold text-[#1d345d] mb-1"
                        x-text="$store.lang.current === 'en' ? 'Personal Information' : 'Información Personal'"></h3>
                    <p class="text-[#9298af] text-sm mb-6"
                       x-text="$store.lang.current === 'en' ? 'Required fields are marked with *' : 'Los campos obligatorios están marcados con *'"></p>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="full_name" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Full Name *' : 'Nombre Completo *'"></label>
                            <input type="text" id="full_name" name="full_name" required value="{{ old('full_name') }}"
                                   x-bind:placeholder="$store.lang.current === 'en' ? 'Your full name' : 'Tu nombre completo'"
                                   class="w-full px-4 py-3.5 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] placeholder-[#9298af] focus:border-[#e7333e] focus:ring-2 focus:ring-[#e7333e]/20 focus:bg-white focus:outline-none transition-all">
                            @error('full_name') <p class="text-[#e7333e] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Email *' : 'Correo Electrónico *'"></label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                   placeholder="you@example.com"
                                   class="w-full px-4 py-3.5 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] placeholder-[#9298af] focus:border-[#e7333e] focus:ring-2 focus:ring-[#e7333e]/20 focus:bg-white focus:outline-none transition-all">
                            @error('email') <p class="text-[#e7333e] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div class="sm:col-span-2">
                            <label for="phone" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Phone' : 'Teléfono'"></label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   placeholder="+1 (555) 000-0000"
                                   class="w-full px-4 py-3.5 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] placeholder-[#9298af] focus:border-[#e7333e] focus:ring-2 focus:ring-[#e7333e]/20 focus:bg-white focus:outline-none transition-all">
                        </div>
                    </div>
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-[#9298af]/30 to-transparent"></div>

                {{-- Step 2: Documents --}}
                <div>
                    <h3 class="text-lg font-display font-bold text-[#1d345d] mb-1"
                        x-text="$store.lang.current === 'en' ? 'Required Documents' : 'Documentos Requeridos'"></h3>
                    <p class="text-[#9298af] text-sm mb-6"
                       x-text="$store.lang.current === 'en' ? 'Upload your documents (PDF, DOC, DOCX — max 10MB each)' : 'Sube tus documentos (PDF, DOC, DOCX — máx. 10MB cada uno)'"></p>
                    <div class="space-y-5">
                        <div>
                            <label for="cv" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Curriculum Vitae (CV) *' : 'Currículum Vitae (CV) *'"></label>
                            <input type="file" id="cv" name="cv" required accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#1d345d]/10 file:text-[#1d345d] file:font-semibold file:text-sm hover:file:bg-[#1d345d]/20 transition-all">
                            @error('cv') <p class="text-[#e7333e] text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="nda" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Non-Disclosure Agreement (NDA)' : 'Acuerdo de No Divulgación (NDA)'"></label>
                            <input type="file" id="nda" name="nda" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#1d345d]/10 file:text-[#1d345d] file:font-semibold file:text-sm hover:file:bg-[#1d345d]/20 transition-all">
                        </div>
                        <div>
                            <label for="interview_request" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Interview Request' : 'Solicitud de Entrevista'"></label>
                            <input type="file" id="interview_request" name="interview_request" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#1d345d]/10 file:text-[#1d345d] file:font-semibold file:text-sm hover:file:bg-[#1d345d]/20 transition-all">
                        </div>
                        <div>
                            <label for="application_form" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Application Form' : 'Formulario de Aplicación'"></label>
                            <input type="file" id="application_form" name="application_form" accept=".pdf,.doc,.docx"
                                   class="w-full px-4 py-3 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-[#1d345d]/10 file:text-[#1d345d] file:font-semibold file:text-sm hover:file:bg-[#1d345d]/20 transition-all">
                        </div>
                    </div>
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-[#9298af]/30 to-transparent"></div>

                {{-- Step 3: Experience --}}
                <div>
                    <h3 class="text-lg font-display font-bold text-[#1d345d] mb-1"
                        x-text="$store.lang.current === 'en' ? 'Additional Information' : 'Información Adicional'"></h3>
                    <p class="text-[#9298af] text-sm mb-6"
                       x-text="$store.lang.current === 'en' ? 'Tell us about your relevant experience' : 'Cuéntanos sobre tu experiencia relevante'"></p>
                    <div class="space-y-5">
                        <div>
                            <label for="experience_summary" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Experience Summary' : 'Resumen de Experiencia'"></label>
                            <textarea id="experience_summary" name="experience_summary" rows="4"
                                      x-bind:placeholder="$store.lang.current === 'en' ? 'Briefly describe your relevant experience...' : 'Describe brevemente tu experiencia relevante...'"
                                      class="w-full px-4 py-3.5 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] placeholder-[#9298af] focus:border-[#e7333e] focus:ring-2 focus:ring-[#e7333e]/20 focus:bg-white focus:outline-none transition-all resize-none">{{ old('experience_summary') }}</textarea>
                        </div>
                        <div>
                            <label for="cover_letter" class="block text-[#1d345d] text-sm font-semibold mb-2"
                                   x-text="$store.lang.current === 'en' ? 'Cover Letter' : 'Carta de Presentación'"></label>
                            <textarea id="cover_letter" name="cover_letter" rows="4"
                                      x-bind:placeholder="$store.lang.current === 'en' ? 'Why are you interested in this position?' : '¿Por qué te interesa esta posición?'"
                                      class="w-full px-4 py-3.5 rounded-xl bg-[#eff6ef] border border-[#9298af]/30 text-[#1d345d] placeholder-[#9298af] focus:border-[#e7333e] focus:ring-2 focus:ring-[#e7333e]/20 focus:bg-white focus:outline-none transition-all resize-none">{{ old('cover_letter') }}</textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="flex items-center justify-center gap-2 w-full bg-[#e7333e] hover:bg-[#d42d37] text-white font-semibold py-4 rounded-xl text-base transition-all duration-300 shadow-lg shadow-[#e7333e]/25 hover:shadow-xl hover:shadow-[#e7333e]/30">
                    <span x-text="$store.lang.current === 'en' ? 'Submit Application' : 'Enviar Aplicación'"></span>
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                </button>
            </form>
        </div>
    </div>
</section>
@endsection
