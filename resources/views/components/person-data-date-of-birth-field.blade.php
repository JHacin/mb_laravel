<div class="field">
    <label for="date_of_birth" class="label">{{ trans('person_data.date_of_birth') }}</label>
    <div class="control">
        <input
            name="personData[date_of_birth]"
            id="date_of_birth"
            class="input @error('personData.date_of_birth') is-danger @enderror"
            type="text"
            placeholder="{{ trans('person_data.date_of_birth') }}"
            value="{{ old('personData.date_of_birth') ?? $attributes['value'] ?? '' }}"
            {{ $attributes }}
        >
    </div>
    @error('personData.date_of_birth')
    <p class="help is-danger">{{ $message }}</p>
    @enderror
</div>

@push('footer-scripts')
    <script>
        flatpickr(document.getElementById('date_of_birth'), {
            altInput: true,
            altFormat: 'j. n. Y',
            dateFormat: 'Y-m-d',
            maxDate: dayjs().toDate()
        });
    </script>
@endpush
