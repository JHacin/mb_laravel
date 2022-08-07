import { useEffect } from 'react';
import { UseFormWatch } from 'react-hook-form';

interface UseGlobalFormDataParams<TFields> {
  watch: UseFormWatch<TFields>;
  callback: (data: TFields) => void;
}

export const useStoreValuesSync = <TFields>({
  watch,
  callback,
}: UseGlobalFormDataParams<TFields>) => {
  useEffect(() => {
    const subscription = watch((data) => {
      callback(data as TFields); // forcing type because watch returns a partial type
    });

    return () => subscription.unsubscribe();
  }, [watch]);
};
