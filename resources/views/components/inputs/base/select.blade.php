@props(['name', 'label', 'options', 'selected'])

<x-inputs.inc.wrapper name="{{ $name }}" label="{{ $label }}" {{ $attributes }}>
    <x-slot name="input">
        <div class="select">
            <select
                id="{{ $name }}"
                name="{{ $name }}"
                {{ $attributes->except(['value']) }}
            >
                @foreach($options as $optionValue => $label)
                    <option
                        value="{{ $optionValue }}"
                        {{ isset($selected) && $optionValue === $selected ? 'selected' : '' }}
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </x-slot>
</x-inputs.inc.wrapper>
