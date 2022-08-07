import { AnySchema } from 'yup'
import Reference from 'yup/lib/Reference'
import Lazy from 'yup/lib/Lazy'
import { PersonGender, SelectOption } from '../../types'

export type YupValidationSchemaShape<TFields> = Record<
  keyof TFields,
  AnySchema | Reference | Lazy<any, any>
  >;

export interface FormStatus {
  isSubmitting: boolean;
  isSubmitSuccess: boolean;
  isSubmitError: boolean;
}

export interface FormStore<TValues, TAnyStepFields> {
  values: TValues;
  status: FormStatus;
  updateValues: (payload: TAnyStepFields) => void;
  updateStatus: (payload: Partial<FormStatus>) => void;
}

export enum Step {
  SPONSORSHIP_PARAMS = 'sponsorshipParams',
  PAYER_DETAILS = 'payerDetails',
  GIFTEE_DETAILS = 'gifteeDetails',
  SUMMARY = 'summary',
}

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

export interface SponsorshipFormSharedStepProps {
  onPrev: () => void;
  onNext: () => void;
  onFinalSubmit: () => void;
  countryOptions: SelectOption[];
  genderOptions: SelectOption[];
  contactEmail: string;
}

export interface SponsorshipParamsStepFields {
  is_gift: boolean;
  is_anonymous: boolean;
}

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

export interface SponsorshipFormSummaryStepFields {
  is_agreed_to_terms: boolean;
}
