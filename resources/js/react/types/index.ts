import { Key } from 'react';
import { AnySchema } from 'yup';

export interface SponsorshipFormServerSideProps {
  requestUrl: string;
  countryList: {
    options: Record<string, string>;
    default: string;
  };
  gender: {
    options: Record<string, string>;
    default: number;
  };
  contactEmail: string;
}

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

export type YupValidationSchemaShape<TFields> = Record<keyof TFields, AnySchema>;

export interface PayerFields {
  payer_email: string;
  payer_first_name: string;
  payer_last_name: string;
  payer_gender: PersonGender;
  payer_address: string;
  payer_zip_code: string;
  payer_city: string;
  payer_country: string;
}

export interface GifteeFields {
  giftee_email: string;
  giftee_first_name: string;
  giftee_last_name: string;
  giftee_gender: PersonGender;
  giftee_address: string;
  giftee_zip_code: string;
  giftee_city: string;
  giftee_country: string;
}
