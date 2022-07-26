import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from '../actions/updateFormDataAction';
import { updateFormStateAction } from '../actions/updateFormStateAction';
import { SpecialSponsorshipFormState } from '../types';

export type SpecialSponsorshipFormStateActions = ReturnType<typeof useGlobalState>['actions'];

export const useGlobalState = () => {
  const { state, actions } = useStateMachine({ updateFormDataAction, updateFormStateAction });

  return {
    state: state as SpecialSponsorshipFormState,
    actions,
  };
};
