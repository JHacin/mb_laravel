@props(['icon'])

@php
/** @var string $icon */
$icon_class = match ($icon) {
    'arrow-right' => 'fas fa-arrow-circle-right',
    'burger' => 'fas fa-bars',
    'plus' => 'fas fa-plus',
    'instagram' => 'fab fa-instagram',
    'facebook' => 'fab fa-facebook-f',
    'email' => 'far fa-envelope',
    'heart' => 'fas fa-heart'
}
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center']) }}>
    <i class="{{ $icon_class }}"></i>
</span>
