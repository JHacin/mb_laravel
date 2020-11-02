@props(['name', 'label'])

@php
    $defaultAttributes = [
        'type' => 'number',
        'min' => '0.00',
        'max' => config('money.decimal_max'),
        'step' => '0.01',
    ]
@endphp

<x-inputs.base.input
    name="{{ $name }}"
    label="{{ $label }}"
    {{ $attributes->merge($defaultAttributes) }}
/>
