import { AnyStepFields, SpecialSponsorshipFormState } from '../types'

export const updateFormDataAction = <TFields extends AnyStepFields>(
  state: SpecialSponsorshipFormState,
  payload: TFields
): SpecialSponsorshipFormState => ({
  ...state,
  formData: {
    ...state.formData,
    ...payload,
  },
});
