<!-- Registration Wizard Component -->
<div 
    class="min-h-screen bg-gradient-to-br from-slate-50 via-orange-50/20 to-amber-50/30 py-8 md:py-12 px-4"
    x-data="{ showConfetti: false }"
    @registration-success.window="showConfetti = true; setTimeout(() => showConfetti = false, 5000)"
    @redirect-to-dashboard.window="setTimeout(() => window.location.href = '{{ route('student.dashboard') }}', 3000)"
>
    @if($showConfetti ?? false)
        <div class="fixed inset-0 pointer-events-none z-50" x-show="showConfetti" x-transition>
            <!-- Confetti effect using CSS/JS can be added here -->
        </div>
    @endif

    @if($isSuccess)
        <div class="min-h-screen bg-gradient-to-br from-orange-50 via-white to-amber-50 flex items-center justify-center p-4">
            <div 
                x-data="{ loaded: false }"
                x-init="setTimeout(() => loaded = true, 100)"
                x-show="loaded"
                x-transition:enter="transition ease-out duration-600"
                x-transition:enter-start="opacity-0 translate-y-5"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="max-w-2xl w-full"
            >
                <x-glass-card class="p-8 md:p-12 text-center" :noAnimation="true">
                    <!-- Success Icon -->
                    <div 
                        x-data="{ scale: 0 }"
                        x-init="setTimeout(() => scale = 1, 200)"
                        class="w-24 h-24 bg-gradient-to-br from-green-400 to-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg"
                        :style="'transform: scale(' + scale + ')'"
                    >
                        <i class="ph ph-check-circle text-6xl text-white"></i>
                    </div>

                    <!-- Congratulations Title -->
                    <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4">
                        🎉 Selamat! 🎉
                    </h2>

                    <!-- Success Message -->
                    <p class="text-xl md:text-2xl font-bold text-brand-orange mb-6">
                        Pendaftaran Anda Berhasil!
                    </p>

                    <!-- Encouragement Message -->
                    <div class="space-y-4 mb-8">
                        <p class="text-lg text-gray-700 leading-relaxed">
                            Terima kasih telah mempercayakan perjalanan belajar Anda kepada <strong class="text-brand-orange">Rumba Athaya</strong>!
                        </p>
                        <p class="text-lg text-gray-700 leading-relaxed">
                            <strong class="text-slate-900">Semangat belajar!</strong> 🚀<br />
                            Kami yakin Anda akan meraih prestasi gemilang bersama kami.
                        </p>
                    </div>

                    <!-- Waiting Message -->
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-2xl p-6 md:p-8 mb-6">
                        <div class="flex items-start gap-4">
                            <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                <i class="ph ph-phone text-2xl text-white"></i>
                            </div>
                            <div class="text-left">
                                <h3 class="font-bold text-blue-900 text-lg mb-2">
                                    Menunggu Dihubungi
                                </h3>
                                <p class="text-blue-800 leading-relaxed">
                                    Mohon menunggu, <strong>kakak-kakak Rumba Athaya</strong> akan segera menghubungi Anda melalui nomor telepon yang telah Anda berikan.
                                </p>
                                <p class="text-blue-800 mt-3 leading-relaxed">
                                    Pastikan nomor telepon Anda aktif dan siap menerima panggilan dari kami. Kami akan menghubungi Anda dalam waktu <strong>1-2 hari kerja</strong>.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Motivational Quote -->
                    <div class="border-t border-gray-200 pt-6">
                        <p class="text-gray-600 italic text-base">
                            "Belajar adalah investasi terbaik untuk masa depan"
                        </p>
                        <p class="text-gray-500 text-sm mt-2">
                            - Tim Rumba Athaya
                        </p>
                    </div>

                    <!-- Redirect Button -->
                    <div class="mt-8">
                        <a href="{{ route('student.dashboard') }}" class="inline-flex items-center justify-center gap-2 min-w-[200px] h-[52px] bg-gradient-to-r from-brand-orange to-orange-600 text-white font-semibold rounded-xl shadow-lg shadow-orange-500/30 hover:shadow-xl hover:shadow-orange-500/40 transition-all duration-200 hover:-translate-y-0.5">
                            <span>Ke Dashboard</span>
                            <i class="ph ph-arrow-right text-lg"></i>
                        </a>
                    </div>
                </x-glass-card>
            </div>
        </div>
    @else
        <div class="max-w-[1200px] mx-auto">
            <!-- Debug: Current Step = {{ $currentStep }} -->
            <!-- Header -->
            <div class="text-center mb-8 md:mb-12">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-slate-900 mb-2">
                    Formulir <span class="text-brand-orange">Pendaftaran</span>
                </h1>
                <p class="text-gray-600 text-base md:text-lg">Lengkapi data berikut untuk mendaftar program Rumba Athaya</p>
            </div>

            <!-- Main Layout: 2 Columns on Desktop -->
            <div class="grid grid-cols-1 lg:grid-cols-[320px_1fr] gap-6 lg:gap-8">
                
                <!-- Left Sidebar: Stepper (Desktop) -->
                <div class="hidden lg:block">
                    <div class="sticky top-8">
                        <x-glass-card class="p-6" :noAnimation="true">
                            <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-6">Progress</h3>
                            <div class="space-y-6">
                                @foreach($this::STEPS as $index => $step)
                                    @php
                                        $isActive = $step['number'] === $currentStep;
                                        $isCompleted = $step['number'] < $currentStep;
                                        $isUpcoming = $step['number'] > $currentStep;
                                    @endphp
                                    <div class="relative">
                                        <!-- Connector Line -->
                                        @if($index < count($this::STEPS) - 1)
                                            <div class="absolute left-6 top-12 w-0.5 h-8 transition-all duration-300 {{ $isCompleted ? 'bg-brand-orange' : 'bg-gray-200' }}"></div>
                                        @endif

                                        <div class="flex items-start gap-4">
                                            <!-- Step Circle -->
                                            <div class="relative w-12 h-12 rounded-xl flex items-center justify-center font-bold text-sm transition-all duration-300 {{ $isActive ? 'bg-gradient-to-br from-brand-orange to-orange-600 text-white shadow-lg shadow-orange-500/30 scale-110' : ($isCompleted ? 'bg-brand-orange text-white' : 'bg-gray-100 text-gray-400') }}"
                                                 x-data="{ scale: {{ $isActive ? '1.1' : '1' }} }"
                                                 x-init="@if($isActive) setTimeout(() => scale = 1.1, 100) @endif">
                                                @if($isCompleted)
                                                    <i class="ph ph-check text-lg"></i>
                                                @else
                                                    {{ $step['number'] }}
                                                @endif
                                            </div>

                                            <!-- Step Info -->
                                            <div class="flex-1 pt-1">
                                                <h4 class="font-semibold text-sm mb-0.5 transition-colors {{ $isActive ? 'text-brand-orange' : ($isCompleted ? 'text-slate-900' : 'text-gray-500') }}">
                                                    {{ $step['title'] }}
                                                </h4>
                                                <p class="text-xs transition-colors {{ $isActive || $isCompleted ? 'text-gray-600' : 'text-gray-400' }}">
                                                    {{ $step['description'] }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </x-glass-card>
                    </div>
                </div>

                <!-- Right Side: Form Content -->
                <div class="flex-1">
                    <!-- Mobile Stepper -->
                    <div class="lg:hidden mb-8">
                        <x-glass-card class="p-4" :noAnimation="true">
                            <div class="flex items-center justify-between">
                                @foreach($this::STEPS as $index => $step)
                                    @php
                                        $isActive = $step['number'] === $currentStep;
                                        $isCompleted = $step['number'] < $currentStep;
                                    @endphp
                                    <div class="flex items-center flex-1">
                                        <div class="flex flex-col items-center flex-1">
                                            <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold text-xs transition-all {{ $isActive ? 'bg-gradient-to-br from-brand-orange to-orange-600 text-white shadow-lg' : ($isCompleted ? 'bg-brand-orange text-white' : 'bg-gray-200 text-gray-500') }}"
                                                 x-data="{ scale: {{ $isActive ? '1.1' : '1' }} }"
                                                 :style="'transform: scale(' + scale + ')'">
                                                @if($isCompleted)
                                                    <i class="ph ph-check text-sm"></i>
                                                @else
                                                    {{ $step['number'] }}
                                                @endif
                                            </div>
                                            <span class="text-[10px] mt-1.5 font-medium text-center {{ $isActive ? 'text-brand-orange' : 'text-gray-500' }}">
                                                {{ $step['title'] }}
                                            </span>
                                        </div>
                                        @if($index < count($this::STEPS) - 1)
                                            <div class="flex-1 h-0.5 mx-2 rounded-full transition-all {{ $isCompleted ? 'bg-brand-orange' : 'bg-gray-200' }}"></div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </x-glass-card>
                    </div>

                    <!-- Form Card -->
                    <div>
                        @if($currentStep === 1)
                            @include('livewire.registration-wizard.step1')
                        @elseif($currentStep === 2)
                            @include('livewire.registration-wizard.step2')
                        @elseif($currentStep === 3)
                            @include('livewire.registration-wizard.step3')
                        @elseif($currentStep === 4)
                            @include('livewire.registration-wizard.step4')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
