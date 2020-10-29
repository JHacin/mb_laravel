<div class="field">
    <label for="city" class="label">{{ trans('person_data.city') }}</label>
    <div class="control">
        <input
            name="personData[city]"
            id="city"
            class="input @error('personData.city') is-danger @enderror"
            type="text"
            placeholder="{{ trans('person_data.city') }}"
            value="{{ old('personData.city') ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error('personData.city')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
