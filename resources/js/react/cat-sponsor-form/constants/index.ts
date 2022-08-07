import { BoxOptionItem } from '../../types';

export const AMOUNT_OPTIONS: BoxOptionItem[] = [
  { label: '5€', value: 5, key: '5' },
  { label: '10€', value: 10, key: '10' },
  { label: '20€', value: 20, key: '20' },
  { label: '50€', value: 50, key: '50' },
];

export const REQUESTED_DURATION_OPTIONS: BoxOptionItem[] = [
  { label: 'Do preklica', value: null, key: 'null' },
  { label: '1 mesec', value: 1, key: '1' },
  { label: '6 mesecev', value: 6, key: '6' },
  { label: '1 leto', value: 12, key: '12' },
];
