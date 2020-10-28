import dayjs from 'dayjs';
import flatpickr from './packages/flatpickr';

flatpickr(document.getElementById('date_of_birth'), {
    altInput: true,
    altFormat: 'j. n. Y',
    dateFormat: 'Y-m-d',
    maxDate: dayjs().toDate(),
});
