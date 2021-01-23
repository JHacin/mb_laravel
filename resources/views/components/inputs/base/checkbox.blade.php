@props(['name', 'label', 'isChecked' => false])

@php
    /** @var string $name */
    $bracketToDotConvertedName = str_replace(['[', ']'], ['.', ''], $name)
@endphp

<div class="field" dusk="{{ $name }}-input-wrapper">
    <div class="control">
        <label class="checkbox is-flex is-align-items-center" for="{{ $name }}">
            <input
                type="checkbox"
                id="{{ $name }}"
                class="mr-2"
                name="{{ $name }}"
                dusk="{{ $name }}-input"
                {{ (old($bracketToDotConvertedName) || $isChecked) ? 'checked' : '' }}
                {{ $attributes->merge(['value' => 1]) }}
            >
            <span>{{ $label }}</span>
        </label>
    </div>
    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
