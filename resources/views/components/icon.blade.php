@props(['icon'])

{{-- blade-formatter-disable --}}
@php
/** @var string $icon */
$icon_class = match ($icon) {
    'arrow-right' => 'fas fa-arrow-circle-right',
    'burger' => 'fas fa-bars',
    'close' => 'fas fa-times',
    'plus' => 'fas fa-plus',
    'instagram' => 'fab fa-instagram',
    'facebook' => 'fab fa-facebook-f',
    'email' => 'far fa-envelope',
    'heart' => 'fas fa-heart',
    'chevron-left' => 'fas fa-chevron-left',
    'chevron-right' => 'fas fa-chevron-right',
    'paw' => 'fas fa-paw',
    'search' => 'fas fa-search',
}
@endphp
{{-- blade-formatter-enable --}}

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center']) }}>
    <i class="{{ $icon_class }}"></i>
</span>
