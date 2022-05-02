import React, { FC } from 'react';
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
import { GifteeDetailsStepFields, PersonType, SelectOption } from '../types';

interface GifteeDetailsStepProps {
  onPrev: () => void;
  onNext: () => void;
  countryOptions: SelectOption[];
  genderOptions: SelectOption[];
}

export const GifteeDetailsStep: FC<GifteeDetailsStepProps> = ({
  onPrev,
  onNext,
  countryOptions,
  genderOptions,
}) => {
  const { actions } = useGlobalState();

  const validationSchema = yup.object(createPersonDataValidationRules(PersonType.Giftee));

  const methods = useForm<GifteeDetailsStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  const onSubmit = (data: GifteeDetailsStepFields) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  useGlobalSync<GifteeDetailsStepFields>({ watch: methods.watch });

  return (
    <FormProvider {...methods}>
      <form onSubmit={methods.handleSubmit(onSubmit)}>
        <PersonDataFields
          prefix={PersonType.Giftee}
          countryOptions={countryOptions}
          genderOptions={genderOptions}
        />

        <ButtonRow>
          <BackButton onClick={onPrev} />
          <SubmitButton>Naprej</SubmitButton>
        </ButtonRow>
      </form>
    </FormProvider>
  );
};
