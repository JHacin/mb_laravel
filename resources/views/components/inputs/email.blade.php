@props(['name' => 'email'])

<x-inputs.base.input
    name="{{ $name }}"
    label="{{ trans('user.email') }}"
    {{ $attributes->merge(['type' => 'email']) }}
/>
