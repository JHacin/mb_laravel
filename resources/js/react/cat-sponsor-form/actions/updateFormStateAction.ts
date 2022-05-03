import { CatSponsorFormState } from '../types';

export const updateFormStateAction = (
  state: CatSponsorFormState,
  payload: Partial<CatSponsorFormState['formState']>
): CatSponsorFormState => ({
  ...state,
  formState: {
    ...state.formState,
    ...payload,
  },
});
