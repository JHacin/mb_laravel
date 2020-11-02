@props(['name', 'label'])

@php
    use Illuminate\Support\ViewErrorBag;

    /** @var string $name */
    $cleanErrorKey = str_replace(['[', ']'], ['.', ''], $name);
    /** @var ViewErrorBag $errors */
    $hasError = $errors->has($cleanErrorKey);

    $labelText = $label . ($attributes['required'] ? ' *' : '');

    $defaultAttributes = [
        'type' => 'text',
        'class' => 'input' . ($hasError ? ' is-danger' : ''),
        'placeholder' => $labelText,
    ]
@endphp

<x-inputs.inc.wrapper name="{{ $name }}" label="{{ $label }}" {{ $attributes }}>
    <x-slot name="input">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name) ?? $attributes['value'] ?? '' }}"
            {{ $attributes->merge($defaultAttributes) }}
        >
    </x-slot>
</x-inputs.inc.wrapper>
