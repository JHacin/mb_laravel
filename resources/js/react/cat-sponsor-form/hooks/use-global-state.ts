import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from '../actions/updateFormDataAction';
import { updateFormStateAction } from '../actions/updateFormStateAction';

export const useGlobalState = () => {
  return useStateMachine({ updateFormDataAction, updateFormStateAction });
};
