@include('components.inputs.base.input')

@push('footer-scripts')
    <script>
        flatpickr(document.getElementById('{{ $name }}'), {
            altInput: true,
            altFormat: 'j. n. Y',
            dateFormat: 'Y-m-d',
            maxDate: dayjs().toDate()
        });
    </script>
@endpush
