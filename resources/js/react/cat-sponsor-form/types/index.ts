import { GifteeFields, PayerFields, SelectOption, SponsorshipFormServerSideProps } from '../../types'

export interface ServerSideProps extends SponsorshipFormServerSideProps {
  validationConfig: {
    monthly_amount_min: number;
    integer_max: number;
  };
}

export interface SharedStepProps {
  onPrev: () => void;
  onNext: () => void;
  onFinalSubmit: () => void;
  countryOptions: SelectOption[];
  genderOptions: SelectOption[];
  validationConfig: ServerSideProps['validationConfig'];
  contactEmail: ServerSideProps['contactEmail']
}

export interface SponsorshipParamsStepFields {
  is_gift: boolean;
  wants_direct_debit: boolean;
  is_anonymous: boolean;
  monthly_amount: number;
  requested_duration: number | null;
}

export interface PayerDetailsStepFields extends PayerFields {}

export interface GifteeDetailsStepFields extends GifteeFields {}

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
    isSubmitSuccess: boolean;
    isSubmitError: boolean;
  };
}

export enum Step {
  SPONSORSHIP_PARAMS = 'sponsorshipParams',
  PAYER_DETAILS = 'payerDetails',
  GIFTEE_DETAILS = 'gifteeDetails',
  SUMMARY = 'summary',
}
