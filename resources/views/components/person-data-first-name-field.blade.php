<div class="field">
    <label for="first_name" class="label">{{ trans('person_data.first_name') }}</label>
    <div class="control">
        <input
            name="personData[first_name]"
            id="first_name"
            class="input @error('personData.first_name') is-danger @enderror"
            type="text"
            placeholder="{{ trans('person_data.first_name') }}"
            value="{{ old('personData.first_name') ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error('personData.first_name')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
