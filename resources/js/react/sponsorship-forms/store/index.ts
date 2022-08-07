import create from 'zustand';
import { FormStore } from '../types';

export const createFormStore = <TValues, TAnyStepFields>({
  initialValues,
}: {
  initialValues: TValues;
}) => {
  return create<FormStore<TValues, TAnyStepFields>>((setState) => ({
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
