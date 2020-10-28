import lodash from 'lodash';
import axios from 'axios';
import dayjs from 'dayjs';
import 'dayjs/locale/sl';

window._ = lodash;

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

dayjs.locale('sl');
