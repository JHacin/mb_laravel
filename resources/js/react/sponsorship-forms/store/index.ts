import { createStore, StoreApi, useStore } from 'zustand'
import { FormStore } from '../types';
import { createContext, useContext } from 'react'

export const SponsorshipFormStoreContext = createContext<any>({});

export const useSponsorshipFormStore = <TFormStore extends FormStore<any, any>>() => {
  const store = useContext<StoreApi<TFormStore>>(SponsorshipFormStoreContext);

  return useStore(store);
};

export const createFormStore = <TValues, TAnyStepFields>({
  initialValues,
}: {
  initialValues: TValues;
}) => {
  return createStore<FormStore<TValues, TAnyStepFields>>((setState) => ({
    values: initialValues,
    status: {
      isSubmitting: false,
      isSubmitSuccess: false,
      isSubmitError: false,
    },
    updateValues: (payload: TAnyStepFields) => {
      setState((state) => ({
        values: {
          ...state.values,
          ...payload,
        },
      }));
    },
    updateStatus: (payload) => {
      setState((state) => ({
        status: {
          ...state.status,
          ...payload,
        },
      }));
    },
  }));
};
