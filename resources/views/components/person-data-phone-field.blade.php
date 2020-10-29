<div class="field">
    <label for="phone" class="label">{{ trans('person_data.phone') }}</label>
    <div class="control">
        <input
            name="personData[phone]"
            id="phone"
            class="input @error('personData.phone') is-danger @enderror"
            type="text"
            placeholder="{{ trans('person_data.phone') }}"
            value="{{ old('personData.phone') ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error('personData.phone')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
