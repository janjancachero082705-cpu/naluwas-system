@props(['active' => false, 'href' => '#'])

@php
$classes = ($active ?? false)
    ? 'flex items-center space-x-3 px-4 py-2 rounded-lg bg-blue-50 text-blue-700 font-medium transition duration-150 ease-in-out'
    : 'flex items-center space-x-3 px-4 py-2 rounded-lg text-gray-600 hover:bg-gray-50 hover:text-gray-900 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['href' => $href, 'class' => $classes]) }}>
    {{ $slot }}
</a>