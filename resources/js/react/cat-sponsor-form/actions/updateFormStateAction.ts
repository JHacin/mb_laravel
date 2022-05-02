import { CatSponsorFormState } from 'react/types';

export const updateFormStateAction = (
  state: CatSponsorFormState,
  payload: Partial<CatSponsorFormState['formState']>
): CatSponsorFormState => {
  return {
    ...state,
    formState: {
      ...state.formState,
      ...payload,
    },
  };
};
