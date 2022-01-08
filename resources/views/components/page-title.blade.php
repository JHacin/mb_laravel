@php
    $classes = implode(' ', [
        'mb-4',
        'text-secondary',
        'text-5xl',
        'font-extrabold',
        'tracking-tight',
        'lg:text-6xl',
        'lg:mb-6',
        'xl:text-7xl',
    ]);
@endphp

<h1 {{ $attributes->merge(['class' => $classes]) }}>
    {{ $text }}
</h1>
