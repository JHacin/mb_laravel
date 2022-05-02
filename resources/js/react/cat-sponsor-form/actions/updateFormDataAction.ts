import { AnyCallback } from 'little-state-machine/dist/types';
import { AnyStepFields, CatSponsorFormState } from 'react/types';

export const updateFormDataAction = <TFields extends AnyStepFields>(
  state: CatSponsorFormState,
  payload: TFields
): CatSponsorFormState => {
  return {
    ...state,
    formData: {
      ...state.formData,
      ...payload,
    },
  };
};
