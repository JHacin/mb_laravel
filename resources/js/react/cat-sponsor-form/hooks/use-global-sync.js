import { useEffect } from 'react';
import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from '../actions/updateFormDataAction';

export function useGlobalSync({ watch }) {
  const { actions } = useStateMachine({ updateFormDataAction });

  useEffect(() => {
    const subscription = watch((data) => {
      // eslint-disable-next-line no-console
      console.log(JSON.stringify(data, null, '\t'));
      actions.updateFormDataAction(data);
    });
    return () => subscription.unsubscribe();
  }, [watch]);
}
