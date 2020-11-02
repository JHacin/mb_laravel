@props(['label' => trans('user.password_confirm')])

<x-inputs.base.input
    name="password_confirmation"
    label="{{ $label }}"
    {{ $attributes->merge(['type' => 'password']) }}
/>
