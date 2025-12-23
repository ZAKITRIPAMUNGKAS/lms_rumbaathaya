<div class="relative min-h-screen p-4 sm:p-8 overflow-hidden font-sans flex items-center justify-center">
    <!-- Animated Background Blobs -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none -z-10 bg-[#F0F4F8]">
        <div
            class="absolute top-0 left-1/4 w-96 h-96 bg-violet-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute top-0 right-1/4 w-96 h-96 bg-fuchsia-400/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-2000">
        </div>
        <div
            class="absolute -bottom-32 left-1/3 w-96 h-96 bg-amber-300/30 rounded-full mix-blend-multiply filter blur-3xl opacity-70 animate-blob animation-delay-4000">
        </div>
    </div>

    <div class="text-center max-w-2xl px-6">
        <div class="relative inline-block mb-8 group">
            <div
                class="absolute inset-0 bg-gradient-to-r from-violet-600 to-fuchsia-600 blur-2xl opacity-20 group-hover:opacity-40 transition-opacity duration-500 rounded-full">
            </div>
            <div
                class="relative w-40 h-40 mx-auto bg-white/40 backdrop-blur-xl border border-white/50 rounded-[2.5rem] flex items-center justify-center shadow-xl shadow-fuchsia-500/10 group-hover:scale-105 transition-transform duration-500">
                <i
                    class="ph-duotone ph-rocket-launch text-7xl text-fuchsia-600 group-hover:rotate-12 transition-transform duration-500"></i>
            </div>

            <!-- Floating Particles -->
            <div class="absolute -top-2 -right-2 text-2xl animate-bounce delay-100">✨</div>
            <div class="absolute top-1/2 -left-8 text-xl animate-pulse delay-700">💫</div>
            <div class="absolute -bottom-2 right-0 text-2xl animate-bounce delay-300">🎯</div>
        </div>

        <h1 class="text-4xl md:text-5xl font-extrabold text-slate-800 mb-4 tracking-tight leading-tight">
            Quiz & Ujian <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-violet-600 to-fuchsia-600">Coming
                Soon!</span>
        </h1>

        <p class="text-lg text-slate-600 font-medium mb-8 leading-relaxed">
            Wah, fitur ini sedang dalam tahap pengembangan oleh tim teknis kami.
            Nantikan fitur seru untuk menguji kemampuanmu segera! 🚀
        </p>

        <a href="{{ route('student.dashboard') }}"
            class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-gradient-to-r from-violet-600 to-fuchsia-600 text-white font-bold text-lg shadow-lg shadow-violet-500/30 hover:shadow-xl hover:-translate-y-1 hover:shadow-violet-500/40 transition-all duration-300">
            <i class="ph-bold ph-arrow-left"></i>
            Kembali ke Dashboard
        </a>
    </div>

    <!-- Blob Animation Style -->
    <style>
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</div>