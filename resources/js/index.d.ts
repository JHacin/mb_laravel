import { AxiosStatic } from 'axios';
import dayjs from 'dayjs';
import flatpickr from 'flatpickr';
import 'little-state-machine';

declare global {
  interface Window {
    axios: AxiosStatic;
    dayjs: typeof dayjs;
    flatpickr: typeof flatpickr;
  }
}

export {};
