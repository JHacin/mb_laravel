@props(['name', 'label', 'options', 'selected'])

<div class="field" dusk="{{ $name }}-input-wrapper">
    @include('components.inputs.inc.label')
    <div class="control">
        <div class="select">
            <!--suppress HtmlFormInputWithoutLabel -->
            <select
                id="{{ $name }}"
                name="{{ $name }}"
                dusk="{{ $name }}-input"
                {{ $attributes }}
            >
                @foreach($options as $optionValue => $optionLabel)
                    <option
                        value="{{ $optionValue }}"
                        @isset($selected){{ $optionValue === $selected ? 'selected' : '' }}@endisset
                    >
                        {{ $optionLabel }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    @include('components.inputs.inc.error')
    @include('components.inputs.inc.help')
</div>


