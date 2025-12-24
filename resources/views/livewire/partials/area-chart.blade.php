@php
    $loading = $loading ?? false;
    if ($loading) {
        $hasData = false;
        $isLoading = true;
    } else {
        $isLoading = false;
        if (!is_array($data) || count($data) === 0) {
            $hasData = false;
        } else {
            $validData = array_values(array_filter($data, function ($d) {
                return isset($d['value']) && is_numeric($d['value']) && !is_nan($d['value']);
            }));
            $hasData = count($validData) > 0;

            if ($hasData) {
                $height = 60;
                $width = 200;
                $max = max(array_column($validData, 'value')) ?: 1;
                $total = array_sum(array_column($validData, 'value'));
                $pointsArray = [];
                foreach ($validData as $i => $d) {
                    $x = count($validData) > 1 ? ($i / (count($validData) - 1)) * $width : $width / 2;
                    $y = $height - ($d['value'] / $max) * $height;
                    $pointsArray[] = ['x' => $x, 'y' => $y, 'value' => $d['value'], 'label' => $d['label'] ?? ''];
                }

                // Handle single point case
                if (count($pointsArray) === 1) {
                    $point = $pointsArray[0];
                    $linePath = "M {$point['x']},{$point['y']} L {$point['x']},{$height}";
                    $areaPath = "M {$point['x']},{$point['y']} L {$point['x']},{$height} L {$width},{$height} L 0,{$height} Z";
                } else {
                    $linePath = 'M ' . implode(' L ', array_map(function ($p) {
                        return "{$p['x']},{$p['y']}"; }, $pointsArray));
                    $areaPath = 'M ' . $pointsArray[0]['x'] . ',' . $pointsArray[0]['y'] . ' L ' . implode(' L ', array_map(function ($p) {
                        return "{$p['x']},{$p['y']}"; }, array_slice($pointsArray, 1))) . ' L ' . $width . ',' . $height . ' L 0,' . $height . ' Z';
                }
                $id = 'gradient-' . preg_replace('/\s+/', '', $title);
            }
        }
    }
@endphp

@if($isLoading)
    <div class="h-20 w-full bg-slate-100/50 animate-pulse rounded-lg"></div>
@elseif(!$hasData)
    <div
        class="h-20 w-full flex items-center justify-center text-xs text-slate-400 bg-slate-50/50 rounded-lg border border-dashed border-slate-200">
        No Data</div>
@else
    <div class="w-full group">
        <div class="flex justify-between items-baseline mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">{{ $title }}</span>
            <div class="flex items-baseline gap-1">
                <span class="text-2xl font-black text-slate-800">{{ $total }}</span>
                <span class="text-[10px] font-bold text-slate-400">Total</span>
            </div>
        </div>
        <div class="h-[60px] w-full relative">
            <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="{{ $id }}" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="{{ $colorStart }}" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="{{ $colorEnd }}" stop-opacity="0" />
                    </linearGradient>
                </defs>

                <!-- Grid lines for reference -->
                <line x1="0" y1="{{ $height }}" x2="{{ $width }}" y2="{{ $height }}" stroke="#e2e8f0" stroke-width="0.5"
                    opacity="0.5" vector-effect="non-scaling-stroke" />
                <line x1="0" y1="{{ $height / 2 }}" x2="{{ $width }}" y2="{{ $height / 2 }}" stroke="#e2e8f0" stroke-width="0.5"
                    opacity="0.3" stroke-dasharray="2,2" vector-effect="non-scaling-stroke" />

                <!-- Area fill -->
                <path d="{{ $areaPath }}" fill="url(#{{ $id }})" />

                <!-- Line path -->
                <path d="{{ $linePath }}" fill="none" stroke="{{ $colorStart }}" stroke-width="2" stroke-linecap="round"
                    vector-effect="non-scaling-stroke" />

                <!-- Data points -->
                @foreach($pointsArray as $point)
                    <g class="chart-point" data-value="{{ $point['value'] }}" data-label="{{ $point['label'] }}">
                        <!-- Outer glow circle -->
                        <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="4" fill="{{ $colorStart }}" opacity="0.2"
                            vector-effect="non-scaling-stroke" />
                        <!-- Main point -->
                        <circle cx="{{ $point['x'] }}" cy="{{ $point['y'] }}" r="2.5" fill="{{ $colorStart }}" stroke="white"
                            stroke-width="1.5" vector-effect="non-scaling-stroke"
                            class="transition-all duration-200 hover:r-4" />
                    </g>
                @endforeach
            </svg>

            <!-- Tooltip (hidden by default, shown on hover via Alpine.js) -->
            <div x-data="{ show: false, value: '', label: '', x: 0, y: 0 }" @mouseover.window="
                        const target = $event.target.closest('.chart-point');
                        if (target) {
                            show = true;
                            value = target.dataset.value;
                            label = target.dataset.label;
                            const rect = target.getBoundingClientRect();
                            const container = $el.getBoundingClientRect();
                            x = rect.left - container.left;
                            y = rect.top - container.top - 40;
                        }
                     " @mouseout.window="
                        if (!$event.target.closest('.chart-point')) show = false;
                     " x-show="show" x-transition :style="`left: ${x}px; top: ${y}px;`"
                class="absolute pointer-events-none bg-slate-800 text-white text-xs font-bold px-3 py-1.5 rounded-lg shadow-lg whitespace-nowrap z-10"
                style="display: none;">
                <div class="flex flex-col items-center">
                    <span x-text="value" class="text-sm"></span>
                    <span x-text="label" class="text-[10px] opacity-75"></span>
                </div>
                <!-- Arrow -->
                <div class="absolute left-1/2 -translate-x-1/2 -bottom-1 w-2 h-2 bg-slate-800 rotate-45"></div>
            </div>
        </div>
    </div>
@endif