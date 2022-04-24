import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from '../updateFormDataAction';

export function useGlobalState() {
  return useStateMachine({ updateFormDataAction });
}
