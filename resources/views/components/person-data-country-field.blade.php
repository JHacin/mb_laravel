@php
    use App\Helpers\CountryList;

    $options = CountryList::COUNTRY_NAMES
@endphp

<div class="field">
    <label for="country" class="label">{{ trans('person_data.country') }}</label>
    <div class="control">
        <div class="select">
            <select id="country" name="personData[country]" {{ $attributes }}>
                @foreach($options as $optionValue => $label)
                    <option
                        value="{{ $optionValue }}"
                        {{ $optionValue === $value ? 'selected' : '' }}
                    >
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    @error('personData.country')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
