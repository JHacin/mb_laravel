<div class="field">
    <label for="last_name" class="label">{{ trans('person_data.last_name') }}</label>
    <div class="control">
        <input
            name="personData[last_name]"
            id="last_name"
            class="input @error('personData.last_name') is-danger @enderror"
            type="text"
            placeholder="{{ trans('person_data.last_name') }}"
            value="{{ old('personData.last_name') ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error('personData.last_name')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
