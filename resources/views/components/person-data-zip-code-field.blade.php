<div class="field">
    <label for="zip_code" class="label">{{ trans('person_data.zip_code') }}</label>
    <div class="control">
        <input
            name="personData[zip_code]"
            id="zip_code"
            class="input @error('personData.zip_code') is-danger @enderror"
            type="text"
            placeholder="{{ trans('person_data.zip_code') }}"
            value="{{ old('personData.zip_code') ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error('personData.zip_code')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
