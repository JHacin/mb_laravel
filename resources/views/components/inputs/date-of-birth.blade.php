<x-inputs.base.input
    name="personData[date_of_birth]"
    label="{{ trans('person_data.date_of_birth') }}"
    {{ $attributes }}
/>

@push('footer-scripts')
    <script>
        flatpickr(document.getElementById('personData[date_of_birth]'), {
            altInput: true,
            altFormat: 'j. n. Y',
            dateFormat: 'Y-m-d',
            maxDate: dayjs().toDate()
        });
    </script>
@endpush
