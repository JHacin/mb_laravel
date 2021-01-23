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

<div class="field{{ isset($addon) ? ' has-addons' : '' }}" dusk="{{ $name }}-input-wrapper">
    @include('components.inputs.inc.label')
    <div class="control">
        <!--suppress HtmlFormInputWithoutLabel -->
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($bracketToDotConvertedName) ?? $attributes['value'] ?? '' }}"
            dusk="{{ $name }}-input"
            {{ $attributes->merge($defaultAttributes) }}
        >
    </div>
    @isset($addon)
        {{ $addon }}
    @endisset
    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
