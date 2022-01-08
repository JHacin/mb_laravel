@php
$classes = implode(' ', [
    'md:max-w-screen-md',
    'lg:max-w-screen-lg',
    'xl:max-w-screen-xl',
    '2xl:max-w-screen-2xl',
    'px-4',
    'lg:px-6',
    'mx-auto'
]);
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</div>
