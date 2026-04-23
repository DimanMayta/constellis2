@extends('layouts.app')
@section('title', 'Contact Us — NSG')
@section('content')

<section class="relative py-28 overflow-hidden bg-gradient-to-br from-blue-600 via-blue-700 to-blue-900">
    <div class="absolute inset-0 line-grid opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <span class="text-blue-200 text-sm font-bold tracking-wider uppercase mb-4 block">
            <span x-show="$store.lang.current === 'en'">Get In Touch</span>
            <span x-show="$store.lang.current === 'es'" x-cloak>Contáctenos</span>
        </span>
        <h1 class="section-heading-white mb-6">
            <span x-show="$store.lang.current === 'en'">Contact Us</span>
            <span x-show="$store.lang.current === 'es'" x-cloak>Contáctenos</span>
        </h1>
        <p class="section-subheading-white">
            <span x-show="$store.lang.current === 'en'">Ready to discuss your security needs? Our team is here to help.</span>
            <span x-show="$store.lang.current === 'es'" x-cloak>¿Listo para discutir sus necesidades de seguridad? Nuestro equipo está aquí para ayudarle.</span>
        </p>
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
                            <label for="name" class="block text-slate-700 text-sm font-semibold mb-2">
                                <span x-show="$store.lang.current === 'en'">Full Name *</span>
                                <span x-show="$store.lang.current === 'es'" x-cloak>Nombre Completo *</span>
                            </label>
                            <input type="text" id="name" name="name" required value="{{ old('name') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all"
                                   :placeholder="$store.lang.current === 'en' ? 'Your name' : 'Su nombre'">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="block text-slate-700 text-sm font-semibold mb-2">
                                <span x-show="$store.lang.current === 'en'">Email *</span>
                                <span x-show="$store.lang.current === 'es'" x-cloak>Correo Electrónico *</span>
                            </label>
                            <input type="email" id="email" name="email" required value="{{ old('email') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all"
                                   :placeholder="$store.lang.current === 'en' ? 'you@company.com' : 'tú@correo.com'">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-slate-700 text-sm font-semibold mb-2">
                                <span x-show="$store.lang.current === 'en'">Phone</span>
                                <span x-show="$store.lang.current === 'es'" x-cloak>Teléfono</span>
                            </label>
                            <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all" placeholder="+1 (555) 000-0000">
                        </div>
                        <div>
                            <label for="company" class="block text-slate-700 text-sm font-semibold mb-2">
                                <span x-show="$store.lang.current === 'en'">Company</span>
                                <span x-show="$store.lang.current === 'es'" x-cloak>Empresa</span>
                            </label>
                            <input type="text" id="company" name="company" value="{{ old('company') }}"
                                   class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all"
                                   :placeholder="$store.lang.current === 'en' ? 'Your company' : 'Su empresa'">
                        </div>
                    </div>
                    <div>
                        <label for="subject" class="block text-slate-700 text-sm font-semibold mb-2">
                            <span x-show="$store.lang.current === 'en'">Subject *</span>
                            <span x-show="$store.lang.current === 'es'" x-cloak>Asunto *</span>
                        </label>
                        <input type="text" id="subject" name="subject" required value="{{ old('subject') }}"
                               class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all"
                               :placeholder="$store.lang.current === 'en' ? 'How can we help?' : '¿Cómo podemos ayudarle?'">
                        @error('subject') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="message" class="block text-slate-700 text-sm font-semibold mb-2">
                            <span x-show="$store.lang.current === 'en'">Message *</span>
                            <span x-show="$store.lang.current === 'es'" x-cloak>Mensaje *</span>
                        </label>
                        <textarea id="message" name="message" rows="5" required class="w-full px-4 py-3.5 rounded-xl bg-slate-50 border border-slate-200 text-slate-900 placeholder-slate-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-500/20 focus:bg-white focus:outline-none transition-all resize-none"
                                  :placeholder="$store.lang.current === 'en' ? 'Tell us about your requirements...' : 'Cuéntenos sobre sus requerimientos...'">{{ old('message') }}</textarea>
                        @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <button type="submit" class="btn-primary w-full sm:w-auto">
                        <span x-show="$store.lang.current === 'en'">Send Message</span>
                        <span x-show="$store.lang.current === 'es'" x-cloak>Enviar Mensaje</span>
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                    </button>
                </form>
            </div>

            <div class="lg:col-span-2 space-y-6">
                @php /** @var \App\Models\ContactOffice $office */ @endphp
                @forelse($offices ?? [] as $office)
                    <div class="card p-6">
                        <h3 class="text-slate-900 font-display font-semibold text-lg mb-1">{{ $office->name }}</h3>
                        @if($office->country)
                            <span class="text-blue-600 text-xs font-semibold tracking-wide uppercase mb-4 block">{{ $office->country }}</span>
                        @else
                            <div class="mb-4"></div>
                        @endif
                        <ul class="space-y-4">
                            @if($office->address)
                            <li class="flex items-start gap-3 text-slate-500">
                                <svg class="w-5 h-5 text-blue-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span class="text-sm">{{ $office->address }}</span>
                            </li>
                            @endif
                            @if($office->phone)
                            <li><a href="tel:{{ preg_replace('/[^0-9+]/', '', $office->phone) }}" class="flex items-center gap-3 text-slate-500 hover:text-blue-600 transition-colors text-sm"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>{{ $office->phone }}</a></li>
                            @endif
                            @if($office->email)
                            <li><a href="mailto:{{ $office->email }}" class="flex items-center gap-3 text-slate-500 hover:text-blue-600 transition-colors text-sm"><svg class="w-5 h-5 text-blue-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>{{ $office->email }}</a></li>
                            @endif
                        </ul>
                    </div>
                @empty
                @endforelse
            </div>
        </div>
    </div>
</section>
@endsection
