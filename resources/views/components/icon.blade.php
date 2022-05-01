@props(['icon'])

{{-- blade-formatter-disable --}}
@php
/** @var string $icon */
$icon_class = match ($icon) {
    'burger' => 'fa-solid fa-bars',
    'close' => 'fa-solid fa-xmark',
    'plus' => 'fa-solid fa-plus',
    'instagram' => 'fa-brands fa-instagram',
    'facebook' => 'fa-brands fa-facebook-f',
    'email' => 'fa-solid fa-envelope',
    'chevron-left' => 'fa-solid fa-chevron-left',
    'chevron-right' => 'fa-solid fa-chevron-right',
    'paw' => 'fa-solid fa-paw',
    'search' => 'fa-solid fa-search',
}
@endphp
{{-- blade-formatter-enable --}}

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center']) }}>
    <i class="{{ $icon_class }}"></i>
</span>
