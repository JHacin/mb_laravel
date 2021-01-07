@props(['name', 'label'])

@php
    use Illuminate\Support\ViewErrorBag;
    use Illuminate\View\ComponentAttributeBag;

    /** @var string $name */
    $cleanErrorKey = str_replace(['[', ']'], ['.', ''], $name);
    /** @var ViewErrorBag $errors */
    $hasError = $errors->has($cleanErrorKey);

    $defaultAttributes = [
        'type' => 'text',
        'class' => 'input' . ($hasError ? ' is-danger' : ''),
        'placeholder' => $label,
    ]
@endphp

<div class="field" dusk="{{ $name }}-input-wrapper">
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
    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
