import { Key } from 'react';

export interface SelectOption {
  label: string;
  value: string | number;
  key: Key;
}

export interface BoxOptionItem {
  label: string;
  value: string | number | boolean;
  key: Key;
}

export enum PersonType {
  Payer = 'payer',
  Giftee = 'giftee',
}

export enum PersonGender {
  Male = 1,
  Female = 2,
}
