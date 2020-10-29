@php
    $label = $label ?: trans('user.password_confirm')
@endphp

<div class="field">
    <label class="label" for="password-confirm">{{ $label }}</label>
    <div class="control">
        <input
            class="input @error('password_confirmation') is-danger @enderror"
            type="password"
            id="password-confirm"
            name="password_confirmation"
            placeholder="{{ $label }}"
            {{ $attributes }}
        >
    </div>
    @error('password_confirmation')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
