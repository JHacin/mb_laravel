@props(['label' => trans('user.password')])

<x-inputs.base.input
    name="password"
    label="{{ $label }}"
    {{ $attributes->merge(['type' => 'password']) }}
/>
