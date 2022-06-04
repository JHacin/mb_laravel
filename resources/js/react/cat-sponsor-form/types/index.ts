import { PersonGender, SelectOption } from '../../types';

export interface ServerSideProps {
  requestUrl: string;
  countryList: {
    options: Record<string, string>;
    default: string;
  };
  gender: {
    options: Record<string, string>;
    default: number;
  };
  validationConfig: {
    monthly_amount_min: number;
    monthly_amount_max: number;
  };
}

export interface SharedStepProps {
  onPrev: () => void;
  onNext: () => void;
  onFinalSubmit: () => void;
  countryOptions: SelectOption[];
  genderOptions: SelectOption[];
  validationConfig: ServerSideProps['validationConfig'];
}

export interface SponsorshipParamsStepFields {
  is_gift: boolean;
  wants_direct_debit: boolean;
  is_anonymous: boolean;
  monthly_amount: number;
  duration: number;
}

export interface PayerDetailsStepFields {
  payer_email: string;
  payer_first_name: string;
  payer_last_name: string;
  payer_gender: PersonGender;
  payer_address: string;
  payer_zip_code: string;
  payer_city: string;
  payer_country: string;
}

export interface GifteeDetailsStepFields {
  giftee_email: string;
  giftee_first_name: string;
  giftee_last_name: string;
  giftee_gender: PersonGender;
  giftee_address: string;
  giftee_zip_code: string;
  giftee_city: string;
  giftee_country: string;
}

export interface SummaryStepFields {
  is_agreed_to_terms: boolean;
}

export type AnyStepFields =
  | SponsorshipParamsStepFields
  | PayerDetailsStepFields
  | GifteeDetailsStepFields
  | SummaryStepFields;

export interface CatSponsorFormState {
  formData: SponsorshipParamsStepFields &
    PayerDetailsStepFields &
    GifteeDetailsStepFields &
    SummaryStepFields;
  formState: {
    isSubmitting: boolean;
    hasSubmittedSuccessfully: boolean;
    apiErrors: CatSponsorFormErrorResponse['errors'] | null;
  };
}

export enum Step {
  SPONSORSHIP_PARAMS = 'sponsorshipParams',
  PAYER_DETAILS = 'payerDetails',
  GIFTEE_DETAILS = 'gifteeDetails',
  SUMMARY = 'summary',
}

export interface CatSponsorFormErrorResponse {
  errors: Record<string, string[]>;
  message: string;
}
