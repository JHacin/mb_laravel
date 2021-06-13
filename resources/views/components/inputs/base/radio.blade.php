@props([
    'name',
    'options',
    'label',
    'checked',
    'isInline' => false,
])

@php
    /** @var bool $isInline */
    $classes = [
        'field',
        'mb-radio',
        $isInline ? 'mb-radio--inline' : '',
    ];

    $wrapperClass = implode(' ', array_filter($classes));
@endphp

<div class="{{ $wrapperClass }}" dusk="{{ $name }}-input-wrapper">
    @include('components.inputs.inc.label')

    <div class="control">
        @foreach($options as $value => $label)
            <label class="radio" for="{{ $name }}-{{ $value }}">
                <input
                    type="radio"
                    name="{{ $name }}"
                    id="{{ $name }}-{{ $value }}"
                    value="{{ $value }}"
                    @if($checked){{ $value == $checked ? 'checked' : '' }}@endif
                >
                {{ $label }}
            </label>
        @endforeach
    </div>
</div>
