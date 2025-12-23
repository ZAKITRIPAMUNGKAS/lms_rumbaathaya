<x-filament-widgets::widget>
    <x-filament::section>
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6 p-6 bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-900 rounded-xl border border-blue-100 dark:border-slate-700">
            {{-- Avatar Section --}}
            <div class="flex-shrink-0 relative">
                @if($avatar)
                    <img 
                        src="{{ $avatar }}" 
                        alt="{{ $tutorName }}"
                        class="w-24 h-24 rounded-full border-4 border-white dark:border-slate-700 shadow-lg object-cover"
                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';"
                        loading="lazy"
                    />
                @endif
                <div class="w-24 h-24 rounded-full border-4 border-white dark:border-slate-700 shadow-lg bg-gradient-to-br from-indigo-600 via-purple-600 to-violet-600 flex items-center justify-center text-white text-3xl font-bold {{ $avatar ? 'hidden' : '' }}">
                    {{ strtoupper(substr($tutorName, 0, 2)) }}
                </div>
            </div>

            {{-- Content Section --}}
            <div class="flex-1 text-center md:text-left">
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-2">
                    Selamat Datang, {{ $tutorName }}! 👋
                </h2>
                <p class="text-slate-600 dark:text-slate-300 mb-4">
                    {{ $quote }}
                </p>
                <div class="flex items-center justify-center md:justify-start gap-2 text-sm text-slate-500 dark:text-slate-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{ $email }}</span>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>

