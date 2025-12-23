<div class="space-y-6 p-4 sm:p-8">
    <!-- Page Header (Simplified for Main Layout) -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-800 tracking-tight flex items-center gap-2">
                <i class="ph ph-books text-indigo-600"></i>
                Materi Belajar
            </h1>
            <p class="text-sm text-slate-500 font-medium mt-1">Akses semua modul dan bahan pembelajaran Anda</p>
        </div>
        <!-- Search Bar -->
        <div class="relative w-full sm:w-72">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <i class="ph ph-magnifying-glass text-slate-400"></i>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text"
                class="block w-full pl-10 pr-3 py-2.5 bg-white border border-slate-200 rounded-xl text-sm placeholder-slate-400 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition-all shadow-sm"
                placeholder="Cari materi...">
        </div>
    </div>

    <!-- Category Filter -->
    <div class="flex gap-2 overflow-x-auto pb-2 no-scrollbar">
        <button wire:click="setSubject('all')"
            class="px-4 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-all {{ $activeSubject === 'all' ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
            Semua
        </button>
        @foreach($subjects as $subject)
            <button wire:click="setSubject({{ $subject->id }})"
                class="px-4 py-2 rounded-full text-sm font-bold whitespace-nowrap transition-all {{ $activeSubject === $subject->id ? 'bg-indigo-600 text-white shadow-md shadow-indigo-500/20' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                {{ $subject->name }}
            </button>
        @endforeach
    </div>

    <!-- Materials Grid -->
    @if($materials->count() > 0)
        <!-- Recent/Featured Section could go here -->

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($materials as $material)
                @php
                    // Random-ish aesthetics based on subject ID to keep it consistent per session
                    $styles = [
                        ['bg' => 'from-orange-400 to-pink-500', 'shadow' => 'shadow-orange-500/30', 'icon' => 'ph-calculator'],
                        ['bg' => 'from-blue-400 to-indigo-500', 'shadow' => 'shadow-blue-500/30', 'icon' => 'ph-atom'],
                        ['bg' => 'from-emerald-400 to-teal-500', 'shadow' => 'shadow-emerald-500/30', 'icon' => 'ph-dna'],
                        ['bg' => 'from-violet-400 to-purple-500', 'shadow' => 'shadow-violet-500/30', 'icon' => 'ph-translate'],
                    ];
                    $style = $styles[$material->subject_id % 4] ?? $styles[0];
                @endphp
                <div
                    class="group relative bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all duration-300 flex flex-col h-full overflow-hidden hover:-translate-y-1">
                    <!-- Card Header/Image Placeholder -->
                    <div class="h-32 bg-gradient-to-br {{ $style['bg'] }} relative p-6 flex flex-col justify-between">
                        <div class="absolute top-0 right-0 w-24 h-24 bg-white/10 rounded-full blur-2xl -mr-10 -mt-10"></div>
                        <div class="relative z-10 flex justify-between items-start">
                            <span
                                class="px-2.5 py-1 rounded-lg bg-white/20 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-wider border border-white/10">
                                {{ $material->classLevel->name ?? 'Umum' }}
                            </span>
                            <div
                                class="w-8 h-8 rounded-full bg-white/20 backdrop-blur-md flex items-center justify-center text-white">
                                <i class="{{ $style['icon'] }} text-lg"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-5 flex-1 flex flex-col">
                        <div class="mb-4">
                            <h3
                                class="text-lg font-bold text-slate-800 leading-tight mb-1 line-clamp-2 group-hover:text-indigo-600 transition-colors">
                                {{ $material->title }}
                            </h3>
                            <p class="text-xs font-medium text-slate-400 flex items-center gap-1">
                                <i class="ph ph-chalkboard-teacher"></i>
                                {{ $material->tutor->name ?? 'Admin' }}
                            </p>
                        </div>

                        @if($material->description)
                            <p class="text-sm text-slate-500 line-clamp-2 mb-4 flex-1">
                                {{ strip_tags($material->description) }}
                            </p>
                        @else
                            <div class="flex-1"></div>
                        @endif

                        <!-- Footer -->
                        <div class="pt-4 border-t border-slate-100 flex items-center justify-between mt-auto">
                            <span class="text-[10px] font-bold text-slate-400 uppercase tracking-wider">
                                {{ $material->subject->name ?? 'Mapel' }}
                            </span>
                            <a href="{{ $material->file_path ? asset('storage/' . $material->file_path) : '#' }}"
                                target="_blank"
                                class="inline-flex items-center gap-1 text-xs font-bold text-indigo-600 hover:bg-indigo-50 px-3 py-1.5 rounded-lg transition-colors">
                                <i class="ph ph-download-simple text-sm"></i>
                                Unduh
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $materials->links() }}
        </div>

    @else
        <div class="flex flex-col items-center justify-center py-20 text-center">
            <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mb-6">
                <i class="ph ph-magnifying-glass text-4xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">Tidak Ditemukan</h3>
            <p class="text-slate-500 max-w-sm mx-auto">
                Kami tidak dapat menemukan materi yang cocok dengan pencarian Anda.
            </p>
            <button wire:click="$set('search', '')" class="mt-4 text-sm font-bold text-indigo-600 hover:text-indigo-700">
                Bersihkan Pencarian
            </button>
        </div>
    @endif
</div>