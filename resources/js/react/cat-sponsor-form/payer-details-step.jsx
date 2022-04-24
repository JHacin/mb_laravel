import React from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { FORM_MODE } from './constants';
import { useGlobalSync } from './hooks/use-global-sync';
import { useGlobalState } from './hooks/use-global-state';
import { createPersonDataValidationRules } from './utils';
import { PersonDataFields } from './components/person-data-fields';

export function PayerDetailsStep({ onPrev, onNext, countryList }) {
  const { actions } = useGlobalState();

  const validationSchema = yup.object(createPersonDataValidationRules('payer'));

  const methods = useForm({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  const onSubmit = (data) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  useGlobalSync({ watch: methods.watch });

  return (
    <FormProvider {...methods}>
      <form onSubmit={methods.handleSubmit(onSubmit)}>
        <PersonDataFields prefix="payer" countryList={countryList} />

        <button type="button" className="mb-btn mb-btn-secondary" onClick={onPrev}>
          Nazaj
        </button>

        <button type="submit" className="mb-btn mb-btn-primary">
          Naprej
        </button>
      </form>
    </FormProvider>
  );
}
