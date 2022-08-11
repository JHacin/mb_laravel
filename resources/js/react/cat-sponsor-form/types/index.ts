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
}

export interface SharedStepProps extends SponsorshipFormSharedStepProps {
  validationConfig: ServerSideProps['validationConfig'];
}

export interface CatSponsorshipParamsStepFields extends SponsorshipParamsStepFields {
  wants_direct_debit: boolean;
  monthly_amount: number;
  requested_duration: number | null;
}

export interface SummaryStepFields extends SponsorshipFormSummaryStepFields {}

export type AnyStepFields =
  | CatSponsorshipParamsStepFields
  | PayerDetailsStepFields
  | GifteeDetailsStepFields
  | SummaryStepFields;

export type CatSponsorshipFormStoreValues = CatSponsorshipParamsStepFields &
  PayerDetailsStepFields &
  GifteeDetailsStepFields &
  SummaryStepFields;

export type CatSponsorshipFormStore = FormStore<CatSponsorshipFormStoreValues, AnyStepFields>;
