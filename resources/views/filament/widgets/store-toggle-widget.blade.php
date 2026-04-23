<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex items-center justify-between flex-wrap gap-4">
            <div class="flex items-center gap-4">
                {{-- Store Icon --}}
                <div class="flex items-center justify-center w-10 h-10 rounded-lg"
                     style="{{ $this->storeEnabled
                         ? 'background: rgba(34,197,94,0.1);'
                         : 'background: rgba(231,51,62,0.1);' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="{{ $this->storeEnabled ? '#16a34a' : '#e7333e' }}">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 21v-7.5a.75.75 0 01.75-.75h3a.75.75 0 01.75.75V21m-4.5 0H2.36m11.14 0H18m0 0h3.64m-1.39 0V9.349m-16.5 11.65V9.35m0 0a3.001 3.001 0 003.75-.615A2.993 2.993 0 009.75 9.75c.896 0 1.7-.393 2.25-1.016a2.993 2.993 0 002.25 1.016c.896 0 1.7-.393 2.25-1.016a3.001 3.001 0 003.75.614m-16.5 0a3.004 3.004 0 01-.621-4.72L4.318 3.44A1.5 1.5 0 015.378 3h13.243a1.5 1.5 0 011.061.44l1.19 1.189a3 3 0 01-.621 4.72m-13.5 8.65h3.75a.75.75 0 00.75-.75V13.5a.75.75 0 00-.75-.75H6.75a.75.75 0 00-.75.75v3.75c0 .415.336.75.75.75z" />
                    </svg>
                </div>

                {{-- Info --}}
                <div>
                    <div class="flex items-center gap-2.5">
                        <p class="text-sm font-semibold text-gray-950 dark:text-white">Employee Store</p>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[11px] font-semibold"
                              style="{{ $this->storeEnabled
                                  ? 'background: rgba(34,197,94,0.1); color: #16a34a;'
                                  : 'background: rgba(231,51,62,0.1); color: #e7333e;' }}">
                            <span class="w-1.5 h-1.5 rounded-full" style="{{ $this->storeEnabled ? 'background:#16a34a' : 'background:#e7333e' }}"></span>
                            {{ $this->storeEnabled ? 'Online' : 'Offline' }}
                        </span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                        {{ $this->storeEnabled
                            ? 'Store is visible in the navigation menu'
                            : 'Store is hidden from the navigation menu' }}
                    </p>
                </div>
            </div>

            {{-- Toggle Button --}}
            <button wire:click="toggleStore"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs font-semibold transition-colors"
                    style="{{ $this->storeEnabled
                        ? 'background: rgba(231,51,62,0.08); color: #e7333e;'
                        : 'background: rgba(34,197,94,0.08); color: #16a34a;' }}"
                    onmouseover="this.style.background='{{ $this->storeEnabled ? 'rgba(231,51,62,0.15)' : 'rgba(34,197,94,0.15)' }}'"
                    onmouseout="this.style.background='{{ $this->storeEnabled ? 'rgba(231,51,62,0.08)' : 'rgba(34,197,94,0.08)' }}'">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5.636 5.636a9 9 0 1012.728 0M12 3v9"/>
                </svg>
                {{ $this->storeEnabled ? 'Disable' : 'Enable' }}
            </button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
