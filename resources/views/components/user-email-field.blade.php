@php
    /** @var string $name */
    $cleanErrorKey = str_replace('[', '.', $name);
    $cleanErrorKey = str_replace(']', '', $cleanErrorKey)
@endphp

<div class="field">
    <label for="{{ $name }}" class="label">{{ trans('user.email') }}*</label>
    <div class="control">
        <input
            name="{{ $name }}"
            id="{{ $name }}"
            class="input @error($cleanErrorKey) is-danger @enderror"
            type="email"
            placeholder="{{ trans('user.email') }}"
            value="{{ old($name) ?? $attributes['value'] ?? '' }}"
            required
            {{ $attributes }}
        >
    </div>
    @error($cleanErrorKey)
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
