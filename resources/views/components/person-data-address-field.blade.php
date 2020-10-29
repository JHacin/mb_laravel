<div class="field">
    <label for="address" class="label">{{ trans('person_data.address') }}</label>
    <div class="control">
        <input
            name="personData[address]"
            id="address"
            class="input @error('personData.address') is-danger @enderror"
            type="text"
            placeholder="{{ trans('person_data.address') }}"
            value="{{ old('personData.address') ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error('personData.address')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
