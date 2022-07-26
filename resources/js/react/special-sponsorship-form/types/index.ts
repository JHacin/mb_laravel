import {
  GifteeFields,
  PayerFields,
  SelectOption,
  SponsorshipFormServerSideProps,
} from '../../types';

export interface ServerSideProps extends SponsorshipFormServerSideProps {
  validationConfig: {
    monthly_amount_min: number;
    integer_max: number;
  };
  sponsorshipTypes: {
    options: Record<string, string>;
    default: string;
    amounts: Record<string, number>;
  };
}

export interface SharedStepProps {
  onPrev: () => void;
  onNext: () => void;
  onFinalSubmit: () => void;
  countryOptions: SelectOption[];
  genderOptions: SelectOption[];
  typeOptions: SelectOption[];
  typeAmounts: Record<string, number>
  validationConfig: ServerSideProps['validationConfig'];
  contactEmail: ServerSideProps['contactEmail'];
}

export interface SponsorshipParamsStepFields {
  type: number;
  is_gift: boolean;
  is_anonymous: boolean;
  donation_amount: number;
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

export interface SpecialSponsorshipFormState {
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
