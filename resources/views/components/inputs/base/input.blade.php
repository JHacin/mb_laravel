@props(['name', 'label'])

@php
    use Illuminate\Support\ViewErrorBag;
    use Illuminate\View\ComponentAttributeBag;

    /** @var string $name */
    $cleanErrorKey = str_replace(['[', ']'], ['.', ''], $name);
    /** @var ViewErrorBag $errors */
    $hasError = $errors->has($cleanErrorKey);

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
            value="{{ old($name) ?? $attributes['value'] ?? '' }}"
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
