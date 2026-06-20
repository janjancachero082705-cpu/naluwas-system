<div {{ $attributes->merge(['class' => 'rounded-[2rem] border border-slate-200/10 bg-white/95 p-8 shadow-2xl shadow-slate-950/20 sm:p-10']) }}>
    @if (isset($logo))
        <div class="flex justify-center mb-6">{{ $logo }}</div>
    @endif

    {{ $slot }}
</div>
