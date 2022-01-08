@php
    $classes = implode(' ', [
        'lg:pl-20',
        'lg:max-w-2xl',
        'xl:pl-24',
        'xl:max-w-3xl',
    ]);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
