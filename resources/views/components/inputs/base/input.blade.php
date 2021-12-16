@props(['name', 'label'])

@php
    use Illuminate\Support\ViewErrorBag;

    /** @var string $name */
    $bracketToDotConvertedName = str_replace(['[', ']'], ['.', ''], $name);
    /** @var ViewErrorBag $errors */
    $hasError = $errors->has($bracketToDotConvertedName);

    /** @var string $label */
    $defaultAttributes = [
        'type' => 'text',
        'class' => 'input' . ($hasError ? ' is-danger' : ''),
        'placeholder' => $label ?? $placeholder ?? '',
    ]
@endphp

<div
    class="{{ isset($addon) ? 'tw-flex tw-justify-start' : '' }}"
    dusk="{{ $name }}-input-wrapper"
>
    @include('components.inputs.inc.label')

    <div class="{{ isset($addon) ? 'tw-mr-[-1px]' : '' }}">
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($bracketToDotConvertedName) ?? $attributes['value'] ?? '' }}"
            dusk="{{ $name }}-input"
            {{ $attributes->merge($defaultAttributes) }}
        >
    </div>

    @isset($addon){{ $addon }}@endisset
    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
