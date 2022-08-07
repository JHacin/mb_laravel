import { Key } from 'react';

export interface SelectOption {
  label: string;
  value: string | number;
  key: Key;
}

export interface BoxOptionItem {
  label: string;
  value: string | number | boolean | null;
  key: Key;
}

export enum PersonGender {
  Male = 1,
  Female = 2,
}
