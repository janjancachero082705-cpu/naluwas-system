@props(['errors'])

@if ($errors && $errors->any())
    <div {{ $attributes->merge(['class' => 'mb-4 rounded-2xl border border-red-200/30 bg-red-50/10 p-4 text-sm text-red-600']) }}>
        <div class="font-semibold text-red-700">Whoops! Something went wrong.</div>
        <ul class="mt-2 list-disc space-y-1 pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
