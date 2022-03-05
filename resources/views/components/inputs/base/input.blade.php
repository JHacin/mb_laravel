@props(['name', 'label'])

@php
use Illuminate\Support\ViewErrorBag;

/** @var string $name */
$bracketToDotConvertedName = str_replace(['[', ']'], ['.', ''], $name);
/** @var ViewErrorBag $errors */
$hasError = $errors->has($bracketToDotConvertedName);

$classes = join(' ', ['w-full', 'bg-gray-extralight', 'border-gray-extralight', 'focus:border-gray-dark', 'focus:ring-0']);

/** @var string $label */
$defaultAttributes = [
    'type' => 'text',
    'class' => $classes . ($hasError ? ' is-danger' : ''),
    'placeholder' => $label ?? ($placeholder ?? ''),
];

$hasAddon = isset($addon);
@endphp

<div
    @class(['w-full', 'flex justify-start' => $hasAddon])
    dusk="{{ $name }}-input-wrapper"
>
    @include('components.inputs.inc.label')

    <div>
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($bracketToDotConvertedName) ?? ($attributes['value'] ?? '') }}"
            dusk="{{ $name }}-input"
            {{ $attributes->merge($defaultAttributes) }}
        >
    </div>

    @if ($hasAddon)
        {{ $addon }}
    @endif

    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
