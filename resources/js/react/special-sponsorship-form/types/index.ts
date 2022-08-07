import { SelectOption } from '../../types';
import {
  GifteeFields,
  PayerFields,
  SponsorshipFormServerSideProps,
  SponsorshipFormSharedStepProps,
  SponsorshipParamsStepFields,
} from '../../sponsorship-forms/types';

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

export interface SharedStepProps extends SponsorshipFormSharedStepProps {
  typeOptions: SelectOption[];
  typeAmounts: Record<string, number>;
  validationConfig: ServerSideProps['validationConfig'];
}

export interface SpecialSponsorshipParamsStepFields extends SponsorshipParamsStepFields {
  type: number;
  donation_amount: number;
}

export interface PayerDetailsStepFields extends PayerFields {}

export interface GifteeDetailsStepFields extends GifteeFields {}

export interface SummaryStepFields {
  is_agreed_to_terms: boolean;
}

export type AnyStepFields =
  | SpecialSponsorshipParamsStepFields
  | PayerDetailsStepFields
  | GifteeDetailsStepFields
  | SummaryStepFields;

export type SpecialSponsorshipFormStoreValues = SpecialSponsorshipParamsStepFields &
  PayerDetailsStepFields &
  GifteeDetailsStepFields &
  SummaryStepFields;
