@props(['name', 'label'])

@php
use Illuminate\Support\ViewErrorBag;

/** @var string $name */
$bracketToDotConvertedName = str_replace(['[', ']'], ['.', ''], $name);
/** @var ViewErrorBag $errors */
$hasError = $errors->has($bracketToDotConvertedName);
$hasAddon = isset($addon);

$classes = ['mb-input peer'];

if ($hasError) {
    $classes[] = 'is-danger';
}

if ($hasAddon) {
    $classes[] = ' mb-input--with-addon';
}

/** @var string $label */
$defaultAttributes = [
    'type' => 'text',
    'class' => join(' ', $classes),
    'placeholder' => $label ?? ($placeholder ?? ''),
];

@endphp

<div
    @class(['w-full', 'flex justify-start' => $hasAddon])
    dusk="{{ $name }}-input-wrapper"
>
    <div class="relative">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($bracketToDotConvertedName) ?? ($attributes['value'] ?? '') }}"
            dusk="{{ $name }}-input"
            {{ $attributes->merge($defaultAttributes) }}
        >


        <label
            for="{{ $name }}"
            class="mb-input-label"
        >{{ $label }}</label>

        @if ($hasAddon)
            <div class="mb-input-addon">{{ $addon }}</div>
        @endif
    </div>

    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
