import React, { FC } from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { createPayerValidationRules } from '../../util';
import { PersonDataFields } from '../../components/person-data-fields';
import { BackButton } from '../../components/back-button';
import { SubmitButton } from '../../components/submit-button';
import { ButtonRow } from '../../components/button-row';
import { SponsorshipFormSharedStepProps } from '../types';
import { useStoreValuesSync } from '../store/use-store-values-sync';
import { FORM_MODE } from '../constants';
import { PayerDetailsStepFields, YupValidationSchemaShape } from '../types';
import {
  AnyStepFields as CatSponsorshipFormAnyStepFields,
  CatSponsorshipFormStoreValues,
} from '../../cat-sponsor-form/types';
import {
  AnyStepFields as SpecialSponsorshipFormAnyStepFields,
  SpecialSponsorshipFormStoreValues,
} from '../../special-sponsorship-form/types';

interface PayereDetailsStepProps extends SponsorshipFormSharedStepProps {
  onPrev: SponsorshipFormSharedStepProps['onPrev'];
  onNext: SponsorshipFormSharedStepProps['onNext'];
  countryOptions: SponsorshipFormSharedStepProps['countryOptions'];
  genderOptions: SponsorshipFormSharedStepProps['genderOptions'];
  values: CatSponsorshipFormStoreValues | SpecialSponsorshipFormStoreValues;
  updateValues: (
    payload: CatSponsorshipFormAnyStepFields | SpecialSponsorshipFormAnyStepFields
  ) => void;
}

export const PayerDetailsStep: FC<PayereDetailsStepProps> = ({
  onPrev,
  onNext,
  countryOptions,
  genderOptions,
  values,
  updateValues,
}) => {
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
