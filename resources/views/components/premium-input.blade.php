@props(['type' => 'text', 'label' => null, 'error' => null, 'icon' => null, 'hint' => null])

<div class="space-y-2">
    @if($label)
        <label class="block text-sm font-semibold text-slate-700">
            {{ $label }}
            @if($attributes->has('required'))
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <div class="relative">
        @if($icon)
            <div class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-lg">
                {!! $icon !!}
            </div>
        @endif
        <input type="{{ $type }}" {{ $attributes->merge([
    'class' => 'w-full pr-4 py-3.5 rounded-xl border-2 transition-all duration-200 text-slate-800 placeholder:text-gray-400 bg-white ' .
        ($icon ? 'pl-12' : 'pl-4') . ' ' .
        ($error
            ? 'border-red-300 focus:border-red-500 focus:ring-2 focus:ring-red-500/20'
            : 'border-gray-200 focus:border-brand-orange focus:ring-2 focus:ring-brand-orange/20'),
]) }}>
        @if($type === 'password')
            <button type="button" x-data="{ show: false }"
                @click="show = !show; $el.previousElementSibling.type = show ? 'text' : 'password'"
                class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-brand-orange transition-colors"
                tabindex="-1">
                <i class="ph text-xl" :class="show ? 'ph-eye-slash' : 'ph-eye'"></i>
            </button>
        @endif
    </div>
    @if($hint)
        <p class="text-xs text-slate-500">{{ $hint }}</p>
    @endif
    @if($error)
        <p class="text-sm text-red-600 font-medium flex items-center gap-1 mt-1.5">
            <i class="ph ph-warning text-base"></i>
            {{ $error }}
        </p>
    @endif
</div>