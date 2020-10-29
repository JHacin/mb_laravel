<div class="field">
    <label for="email" class="label">{{ trans('user.email') }}*</label>
    <div class="control">
        <input
            name="email"
            id="email"
            class="input @error('email') is-danger @enderror"
            type="email"
            placeholder="{{ trans('user.email') }}"
            value="{{ old('email') ?? $attributes['value'] ?? '' }}"
            required
            {{ $attributes }}
        >
    </div>
    @error('email')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
