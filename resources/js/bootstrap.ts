import axios from 'axios';
import dayjs from 'dayjs';
import 'dayjs/locale/sl';
import 'flatpickr/dist/flatpickr.min.css';
import 'flatpickr/dist/themes/airbnb.css';
import flatpickr from 'flatpickr';
import { Slovenian } from 'flatpickr/dist/l10n/sl';

flatpickr.localize(Slovenian);
dayjs.locale('sl');

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.dayjs = dayjs;
window.flatpickr = flatpickr;
