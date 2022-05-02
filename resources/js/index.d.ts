import { AxiosStatic } from 'axios';
import dayjs from 'dayjs';
import flatpickr from 'flatpickr';
import 'little-state-machine';
import { CatSponsorFormState } from './react/types';

declare global {
  interface Window {
    axios: AxiosStatic;
    dayjs: typeof dayjs;
    flatpickr: typeof flatpickr;
  }
}

declare module 'little-state-machine' {
  interface GlobalState extends CatSponsorFormState {}
}

export {};
