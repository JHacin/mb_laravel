import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from '../actions/updateFormDataAction';
import { updateFormStateAction } from "../actions/updateFormStateAction";

export function useGlobalState() {
  return useStateMachine({ updateFormDataAction, updateFormStateAction });
}
