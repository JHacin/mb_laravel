import { useEffect } from 'react';
import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from '../actions/updateFormDataAction';
import { UseFormWatch, WatchObserver } from 'react-hook-form';
import { AnyStepFields, PayerDetailsStepFields } from 'react/types';

interface UseGlobalSyncParams<TFields extends AnyStepFields> {
  watch: UseFormWatch<TFields>;
}

export const useGlobalSync = <TFields extends AnyStepFields>({
  watch,
}: UseGlobalSyncParams<TFields>) => {
  const { actions } = useStateMachine({ updateFormDataAction });

  useEffect(() => {
    const subscription = watch((data) => {
      actions.updateFormDataAction(data as TFields); // forcing type because watch returns a partial type
    });

    return () => subscription.unsubscribe();
  }, [watch]);
};
