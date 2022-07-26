import { SpecialSponsorshipFormState } from '../types';

export const updateFormStateAction = (
  state: SpecialSponsorshipFormState,
  payload: Partial<SpecialSponsorshipFormState['formState']>
): SpecialSponsorshipFormState => ({
  ...state,
  formState: {
    ...state.formState,
    ...payload,
  },
});
