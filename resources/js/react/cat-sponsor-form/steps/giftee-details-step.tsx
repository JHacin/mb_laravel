import React, { FC } from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { FORM_MODE } from '../constants';
import { useGlobalFormDataUpdate } from '../hooks/use-global-form-data-update';
import { useGlobalState } from '../hooks/use-global-state';
import { createGifteeValidationRules } from '../util';
import { PersonDataFields } from '../components/person-data-fields';
import { BackButton } from '../components/back-button';
import { SubmitButton } from '../components/submit-button';
import { ButtonRow } from '../components/button-row';
import { YupValidationSchemaShape } from '../../types';
import { GifteeDetailsStepFields, SharedStepProps } from '../types';

export const GifteeDetailsStep: FC<SharedStepProps> = ({
  onPrev,
  onNext,
  countryOptions,
  genderOptions,
}) => {
  const { actions } = useGlobalState();

  const validationSchema = yup.object<YupValidationSchemaShape<GifteeDetailsStepFields>>(
    createGifteeValidationRules()
  );

  const methods = useForm<GifteeDetailsStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useGlobalFormDataUpdate({ watch: methods.watch, actions });

  const onSubmit = (data: GifteeDetailsStepFields) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  return (
    <FormProvider {...methods}>
      <form onSubmit={methods.handleSubmit(onSubmit)}>
        <PersonDataFields
          prefix="giftee"
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