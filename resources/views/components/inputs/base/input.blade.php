@props(['name', 'label'])

@php
use Illuminate\Support\ViewErrorBag;

/** @var string $name */
$bracketToDotConvertedName = str_replace(['[', ']'], ['.', ''], $name);
/** @var ViewErrorBag $errors */
$hasError = $errors->has($bracketToDotConvertedName);

$classes = ['mb-input'];

if ($hasError) {
    $classes[] = 'is-danger';
}

/** @var string $label */
$defaultAttributes = [
    'type' => 'text',
    'class' => join(' ', $classes),
];

if (isset($placeholder)) {
    $defaultAttributes['placeholder'] = $placeholder;
}

$hasAddon = isset($addon);
@endphp

<div
    class="w-full"
    dusk="{{ $name }}-input-wrapper"
>
    @include('components.inputs.inc.label')

    <div class="flex justify-start">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($bracketToDotConvertedName) ?? ($attributes['value'] ?? '') }}"
            dusk="{{ $name }}-input"
            {{ $attributes->merge($defaultAttributes) }}
        >

        @if ($hasAddon)
            {{ $addon }}
        @endif
    </div>

    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
