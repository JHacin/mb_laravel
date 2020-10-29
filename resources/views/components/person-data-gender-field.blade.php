@php
    use App\Models\PersonData;

    $options = PersonData::GENDER_LABELS
@endphp

<div class="field">
    <label for="gender" class="label">{{ trans('person_data.gender') }}</label>
    <div class="control">
        <div class="select">
            <select id="gender" name="personData[gender]" {{ $attributes }}>
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
    @error('personData.gender')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>
