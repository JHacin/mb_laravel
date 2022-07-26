import React, { FC } from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { FORM_MODE } from '../constants';
import { useGlobalFormDataUpdate } from '../hooks/use-global-form-data-update';
import { useGlobalState } from '../hooks/use-global-state';
import { YupValidationSchemaShape } from '../../types';
import { PayerDetailsStepFields, SharedStepProps } from '../types';
import { createPayerValidationRules } from '../../util';
import { PersonDataFields } from '../../components/person-data-fields';
import { ButtonRow } from '../../components/button-row';
import { BackButton } from '../../components/back-button';
import { SubmitButton } from '../../components/submit-button';

export const PayerDetailsStep: FC<SharedStepProps> = ({
  onPrev,
  onNext,
  countryOptions,
  genderOptions,
}) => {
  const { actions } = useGlobalState();

  const validationSchema = yup.object<YupValidationSchemaShape<PayerDetailsStepFields>>(
    createPayerValidationRules()
  );

  const methods = useForm<PayerDetailsStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useGlobalFormDataUpdate({ watch: methods.watch, actions });

  const onSubmit = (data: PayerDetailsStepFields) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  return (
    <FormProvider {...methods}>
      <form onSubmit={methods.handleSubmit(onSubmit)}>
        <div className="p-5">
          <PersonDataFields
            prefix="payer"
            countryOptions={countryOptions}
            genderOptions={genderOptions}
          />

          <ButtonRow>
            <BackButton onClick={onPrev} />
            <SubmitButton>Naprej</SubmitButton>
          </ButtonRow>
        </div>
      </form>
    </FormProvider>
  );
};
