import React from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { FORM_MODE } from './constants';
import { useGlobalSync } from './hooks/use-global-sync';
import { useGlobalState } from './hooks/use-global-state';
import { createPersonDataValidationRules } from './utils';
import { PersonDataFields } from './components/person-data-fields';
import { BackButton } from './components/back-button';
import { SubmitButton } from './components/submit-button';
import { ButtonRow } from './components/button-row';

export function GifteeDetailsStep({ onPrev, onNext, countryList, genderOptions }) {
  const { actions } = useGlobalState();
  const validationSchema = yup.object(createPersonDataValidationRules('giftee'));

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
        <PersonDataFields prefix="giftee" countryList={countryList} genderOptions={genderOptions} />

        <ButtonRow>
          <BackButton onClick={onPrev} />
          <SubmitButton isDisabled={!methods.formState.isValid}>Naprej</SubmitButton>
        </ButtonRow>
      </form>
    </FormProvider>
  );
}
