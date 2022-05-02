import { AnyStepFields, CatSponsorFormState } from '../../types';

export const updateFormDataAction = <TFields extends AnyStepFields>(
  state: CatSponsorFormState,
  payload: TFields
): CatSponsorFormState => ({
  ...state,
  formData: {
    ...state.formData,
    ...payload,
  },
});
