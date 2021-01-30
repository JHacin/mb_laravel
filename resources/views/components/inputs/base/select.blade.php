@props([
    'name',
    'label',
    'options',
    'selected',
    'isEmptyDefault' => false,
    'wrapperClass' => ''
])

@php
    use Illuminate\Support\ViewErrorBag;

    /** @var string $name */
    $bracketToDotConvertedName = str_replace(['[', ']'], ['.', ''], $name);
    /** @var ViewErrorBag $errors */
    $hasError = $errors->has($bracketToDotConvertedName);

    $baseClasses = 'select' . ($hasError ? ' is-danger' : '');

    $selected = old($bracketToDotConvertedName) ?? $selected ?? null
@endphp

<div class="field" dusk="{{ $name }}-input-wrapper">
    @include('components.inputs.inc.label')
    <div class="control">
        <div class="{{ $baseClasses }}{{ $wrapperClass ? " $wrapperClass" : '' }}">
            <!--suppress HtmlFormInputWithoutLabel -->
            <select
                id="{{ $name }}"
                name="{{ $name }}"
                dusk="{{ $name }}-input"
                {{ $attributes }}
            >
                @if($isEmptyDefault && !$selected)
                    <option disabled selected value class="is-hidden">--</option>
                @endif
                @foreach($options as $optionValue => $optionLabel)
                    <option
                        value="{{ $optionValue }}"
                        @if($selected){{ $optionValue == $selected ? 'selected' : '' }}@endif
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


