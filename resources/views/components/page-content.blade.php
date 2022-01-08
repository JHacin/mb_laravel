@php
    $classes = implode(' ', [
        'py-8',
        'md:py-10',
        'lg:py-12',
    ]);
@endphp

<x-container {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</x-container>
