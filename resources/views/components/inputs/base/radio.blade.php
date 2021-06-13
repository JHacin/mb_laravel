@props([
    'name',
    'options',
    'label',
    'selected',
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
            <label class="radio">
                <input type="radio" name="{{ $name }}">
                {{ $label }}
            </label>
        @endforeach
    </div>
</div>
