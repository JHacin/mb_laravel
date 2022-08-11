import { SelectOption } from '../../types';
import {
  FormStore,
  GifteeDetailsStepFields,
  PayerDetailsStepFields,
  SponsorshipFormServerSideProps,
  SponsorshipFormSharedStepProps,
  SponsorshipFormSummaryStepFields,
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

export interface SummaryStepFields extends SponsorshipFormSummaryStepFields {}

export type AnyStepFields =
  | SpecialSponsorshipParamsStepFields
  | PayerDetailsStepFields
  | GifteeDetailsStepFields
  | SummaryStepFields;

export type SpecialSponsorshipFormStoreValues = SpecialSponsorshipParamsStepFields &
  PayerDetailsStepFields &
  GifteeDetailsStepFields &
  SummaryStepFields;

export type SpecialSponsorshipFormStore = FormStore<
  SpecialSponsorshipFormStoreValues,
  AnyStepFields
>;
