<div class="field">
    <label for="name" class="label">{{ trans('user.name') }}*</label>
    <div class="control">
        <input
            name="name"
            id="name"
            class="input @error('name') is-danger @enderror"
            type="text"
            placeholder="{{ trans('user.name') }}"
            value="{{ old('name') ?? $attributes['value'] ?? '' }}"
            required
            {{ $attributes }}
        >
    </div>
    @error('name')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>


