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
            $validData = array_values(array_filter($data, function($d) { 
                return isset($d['value']) && is_numeric($d['value']) && !is_nan($d['value']); 
            }));
            $hasData = count($validData) > 0;
            
            if ($hasData) {
                $height = 60;
                $width = 200;
                $max = max(array_column($validData, 'value')) ?: 1;
                $pointsArray = [];
                foreach ($validData as $i => $d) {
                    $x = count($validData) > 1 ? ($i / (count($validData) - 1)) * $width : $width / 2;
                    $y = $height - ($d['value'] / $max) * $height;
                    $pointsArray[] = ['x' => $x, 'y' => $y];
                }
                
                // Handle single point case (like React)
                if (count($pointsArray) === 1) {
                    $point = $pointsArray[0];
                    $linePath = "M {$point['x']},{$point['y']} L {$point['x']},{$height}";
                    $areaPath = "M {$point['x']},{$point['y']} L {$point['x']},{$height} L {$width},{$height} L 0,{$height} Z";
                } else {
                    $linePath = 'M ' . implode(' L ', array_map(function($p) { return "{$p['x']},{$p['y']}"; }, $pointsArray));
                    $areaPath = 'M ' . $pointsArray[0]['x'] . ',' . $pointsArray[0]['y'] . ' L ' . implode(' L ', array_map(function($p) { return "{$p['x']},{$p['y']}"; }, array_slice($pointsArray, 1))) . ' L ' . $width . ',' . $height . ' L 0,' . $height . ' Z';
                }
                $id = 'gradient-' . preg_replace('/\s+/', '', $title);
            }
        }
    }
@endphp

@if($isLoading)
    <div class="h-20 w-full bg-slate-100/50 animate-pulse rounded-lg"></div>
@elseif(!$hasData)
    <div class="h-20 w-full flex items-center justify-center text-xs text-slate-400 bg-slate-50/50 rounded-lg border border-dashed border-slate-200">No Data</div>
@else
    <div class="w-full">
        <div class="flex justify-between items-baseline mb-3">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">{{ $title }}</span>
        </div>
        <div class="h-[60px] w-full relative">
            <svg viewBox="0 0 {{ $width }} {{ $height }}" class="w-full h-full overflow-visible" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="{{ $id }}" x1="0" y1="0" x2="0" y2="1">
                        <stop offset="0%" stop-color="{{ $colorStart }}" stop-opacity="0.3" />
                        <stop offset="100%" stop-color="{{ $colorEnd }}" stop-opacity="0" />
                    </linearGradient>
                </defs>
                <path d="{{ $areaPath }}" fill="url(#{{ $id }})" />
                <path d="{{ $linePath }}" fill="none" stroke="{{ $colorStart }}" stroke-width="2" stroke-linecap="round" vector-effect="non-scaling-stroke" />
            </svg>
        </div>
    </div>
@endif
