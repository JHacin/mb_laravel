import React, { FC } from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { createPayerValidationRules } from '../../util';
import { PersonDataFields } from '../../components/person-data-fields';
import { BackButton } from '../../components/back-button';
import { SubmitButton } from '../../components/submit-button';
import { ButtonRow } from '../../components/button-row';
import { PayerDetailsStepFields, SharedStepProps } from '../types';
import { useCatSponsorshipFormStore } from '../store';
import { useStoreValuesSync } from '../../sponsorship-forms/store/use-store-values-sync';
import { FORM_MODE } from '../../sponsorship-forms/constants'
import { YupValidationSchemaShape } from '../../sponsorship-forms/types'

export const PayerDetailsStep: FC<SharedStepProps> = ({
  onPrev,
  onNext,
  countryOptions,
  genderOptions,
}) => {
  const { values, updateValues } = useCatSponsorshipFormStore();

  const validationSchema = yup.object<YupValidationSchemaShape<PayerDetailsStepFields>>(
    createPayerValidationRules()
  );

  const methods = useForm<PayerDetailsStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useStoreValuesSync<PayerDetailsStepFields>({ watch: methods.watch, callback: updateValues });

  const onSubmit = (data: PayerDetailsStepFields) => {
    updateValues(data);
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
            storeValues={values}
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
