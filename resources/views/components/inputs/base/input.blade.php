@props(['name', 'label', 'wrapperDusk' => ''])

@php
    use Illuminate\Support\ViewErrorBag;
    use Illuminate\View\ComponentAttributeBag;

    /** @var string $name */
    $cleanErrorKey = str_replace(['[', ']'], ['.', ''], $name);
    /** @var ViewErrorBag $errors */
    $hasError = $errors->has($cleanErrorKey);

    /** @var string $label */
    /** @var ComponentAttributeBag $attributes */
    $labelText = $label . ($attributes['required'] ? ' *' : '');

    $defaultAttributes = [
        'type' => 'text',
        'class' => 'input' . ($hasError ? ' is-danger' : ''),
        'placeholder' => $labelText,
    ]
@endphp

<div
    class="field"
    @if($wrapperDusk)dusk="{{ $wrapperDusk }}"@endif
>
    @include('components.inputs.inc.label')
    <div class="control">
        <!--suppress HtmlFormInputWithoutLabel -->
        <input
            id="{{ $name }}"
            name="{{ $name }}"
            value="{{ old($name) ?? $attributes['value'] ?? '' }}"
            {{ $attributes->merge($defaultAttributes) }}
        >
    </div>
    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
