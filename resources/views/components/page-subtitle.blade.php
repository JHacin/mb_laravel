@php
    $classes = implode(' ', [
        'text-base',
        'md:text-lg',
        'lg:text-xl',
    ]);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
