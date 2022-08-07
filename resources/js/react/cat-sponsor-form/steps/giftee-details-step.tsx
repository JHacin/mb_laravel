import React, { FC } from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { createGifteeValidationRules } from '../../util';
import { PersonDataFields } from '../../components/person-data-fields';
import { BackButton } from '../../components/back-button';
import { SubmitButton } from '../../components/submit-button';
import { ButtonRow } from '../../components/button-row';
import { GifteeDetailsStepFields, SharedStepProps } from '../types';
import { useCatSponsorshipFormStore } from '../store';
import { useStoreValuesSync } from '../../sponsorship-forms/store/use-store-values-sync';
import { FORM_MODE } from '../../sponsorship-forms/constants'
import { YupValidationSchemaShape } from '../../sponsorship-forms/types'

export const GifteeDetailsStep: FC<SharedStepProps> = ({
  onPrev,
  onNext,
  countryOptions,
  genderOptions,
}) => {
  const { values, updateValues } = useCatSponsorshipFormStore();

  const validationSchema = yup.object<YupValidationSchemaShape<GifteeDetailsStepFields>>(
    createGifteeValidationRules()
  );

  const methods = useForm<GifteeDetailsStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useStoreValuesSync<GifteeDetailsStepFields>({ watch: methods.watch, callback: updateValues });

  const onSubmit = (data: GifteeDetailsStepFields) => {
    updateValues(data);
    onNext();
  };

  return (
    <FormProvider {...methods}>
      <form onSubmit={methods.handleSubmit(onSubmit)}>
        <div className="p-5">
          <PersonDataFields
            prefix="giftee"
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
