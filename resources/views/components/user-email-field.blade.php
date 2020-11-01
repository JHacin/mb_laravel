<div class="field">
    <label for="{{ $name }}" class="label">{{ trans('user.email') }}*</label>
    <div class="control">
        <input
            name="{{ $name }}"
            id="{{ $name }}"
            class="input @error($name) is-danger @enderror"
            type="email"
            placeholder="{{ trans('user.email') }}"
            value="{{ old('email') ?? $attributes['value'] ?? '' }}"
            required
            {{ $attributes }}
        >
    </div>
    @error($name)
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
