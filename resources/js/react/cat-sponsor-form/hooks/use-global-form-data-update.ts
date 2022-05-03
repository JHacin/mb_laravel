import { useEffect } from 'react';
import { UseFormWatch } from 'react-hook-form';
import { AnyStepFields } from '../types';
import { CatSponsorFormStateActions } from './use-global-state';

interface UseGlobalFormDataParams<TFields extends AnyStepFields> {
  watch: UseFormWatch<TFields>;
  actions: CatSponsorFormStateActions;
}

export const useGlobalFormDataUpdate = <TFields extends AnyStepFields>({
  watch,
  actions,
}: UseGlobalFormDataParams<TFields>) => {
  useEffect(() => {
    const subscription = watch((data) => {
      actions.updateFormDataAction(data as TFields); // forcing type because watch returns a partial type
    });

    return () => subscription.unsubscribe();
  }, [watch, actions]);
};
