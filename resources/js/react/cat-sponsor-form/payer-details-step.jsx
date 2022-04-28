import React from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { FORM_MODE } from './constants';
import { useGlobalSync } from './hooks/use-global-sync';
import { useGlobalState } from './hooks/use-global-state';
import { createPersonDataValidationRules } from './utils';
import { PersonDataFields } from './components/person-data-fields';
import { Button } from '../components/button';

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

        <Button type="button" color="secondary" onClick={onPrev}>
          Nazaj
        </Button>

        <Button type="submit" color="primary">
          Naprej
        </Button>
      </form>
    </FormProvider>
  );
}
