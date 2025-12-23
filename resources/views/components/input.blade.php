@props(['type' => 'text', 'label' => null, 'error' => null])

<div class="space-y-2">
    @if($label)
        <label class="block text-sm font-semibold text-slate-700">
            {{ $label }}
            @if($attributes->has('required'))
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    <input 
        type="{{ $type }}"
        {{ $attributes->merge(['class' => 'w-full px-4 py-3 rounded-2xl border-0 bg-white/70 backdrop-blur-xl shadow-sm focus:ring-2 focus:ring-sky-500 focus:bg-white transition-all duration-300 placeholder:text-slate-400']) }}
    >
    @if($error)
        <p class="text-sm text-red-600">{{ $error }}</p>
    @endif
</div>

