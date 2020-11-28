@props(['name', 'label', 'isChecked' => false])

<div class="field" dusk="{{ $name }}-input-wrapper">
    <div class="control">
        <label class="checkbox" for="{{ $name }}">
            <input
                type="checkbox"
                id="{{ $name }}"
                name="{{ $name }}"
                dusk="{{ $name }}-input"
                {{ (old($name) || $isChecked) ? 'checked' : '' }}
                {{ $attributes->merge(['value' => 1]) }}
            >
            {{ $label }}
        </label>
    </div>
    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>
