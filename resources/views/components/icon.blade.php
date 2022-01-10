@props(['icon'])

@php
/** @var string $icon */
$icon_class = match ($icon) {
    'arrow-right' => 'fas fa-arrow-circle-right',
    'burger' => 'fas fa-bars',
}
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center justify-center']) }}>
    <i class="{{ $icon_class }}"></i>
</span>
