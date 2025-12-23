<!-- Ambient Background - Exact copy from React -->
<div class="fixed inset-0 z-0 pointer-events-none overflow-hidden">
    <!-- Animated floating blob 1 -->
    <div class="absolute top-[-10%] right-[-5%] w-[800px] h-[800px] bg-indigo-200/20 rounded-full blur-[120px] mix-blend-multiply animate-blob"></div>
    
    <!-- Animated floating blob 2 -->
    <div class="absolute bottom-[-10%] left-[-10%] w-[600px] h-[600px] bg-purple-200/20 rounded-full blur-[100px] mix-blend-multiply animate-blob" style="animation-duration: 25s; animation-direction: reverse;"></div>
    
    <!-- Animated floating blob 3 -->
    <div class="absolute top-[20%] left-[20%] w-[500px] h-[500px] bg-violet-200/15 rounded-full blur-[100px] mix-blend-multiply animate-blob" style="animation-duration: 18s;"></div>
    
    <!-- Subtle noise texture overlay -->
    <div 
        class="absolute inset-0 opacity-[0.015]"
        style="background-image: url('data:image/svg+xml,%3Csvg viewBox=\'0 0 400 400\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cfilter id=\'noiseFilter\'%3E%3CfeTurbulence type=\'fractalNoise\' baseFrequency=\'0.9\' numOctaves=\'4\' stitchTiles=\'stitch\'/%3E%3C/filter%3E%3Crect width=\'100%25\' height=\'100%25\' filter=\'url(%23noiseFilter)\'/%3E%3C/svg%3E'); background-size: 200px 200px;"
    ></div>
</div>

