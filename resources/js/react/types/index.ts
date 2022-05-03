import { Key } from 'react';
import { AnySchema } from 'yup';

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

export enum PersonGender {
  Male = 1,
  Female = 2,
}

export type YupValidationSchemaShape<TFields> = Record<keyof TFields, AnySchema>;
