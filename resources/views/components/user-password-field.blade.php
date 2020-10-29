@php
    $label = $label ?: trans('user.password')
@endphp

<div class="field">
    <label class="label" for="password">{{ $label }}</label>
    <div class="control">
        <input
            class="input @error('password') is-danger @enderror"
            type="password"
            id="password"
            name="password"
            placeholder="{{ $label }}"
            {{ $attributes }}
        >
    </div>
    @error('password')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
