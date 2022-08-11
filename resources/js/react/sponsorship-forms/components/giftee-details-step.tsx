import React, { FC } from 'react';
import { useForm, FormProvider } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { GifteeDetailsStepFields, SponsorshipFormSharedStepProps } from '../types';
import { createGifteeValidationRules } from '../../util';
import { PersonDataFields } from '../../components/person-data-fields';
import { ButtonRow } from '../../components/button-row';
import { BackButton } from '../../components/back-button';
import { SubmitButton } from '../../components/submit-button';
import { useStoreValuesSync } from '../store/use-store-values-sync';
import { YupValidationSchemaShape } from '../types';
import { FORM_MODE } from '../constants';
import {
  AnyStepFields as CatSponsorshipFormAnyStepFields,
  CatSponsorshipFormStoreValues,
} from '../../cat-sponsor-form/types';
import {
  AnyStepFields as SpecialSponsorshipFormAnyStepFields,
  SpecialSponsorshipFormStoreValues,
} from '../../special-sponsorship-form/types';

interface GifteeDetailsStepProps extends SponsorshipFormSharedStepProps {
  onPrev: SponsorshipFormSharedStepProps['onPrev'];
  onNext: SponsorshipFormSharedStepProps['onNext'];
  countryOptions: SponsorshipFormSharedStepProps['countryOptions'];
  genderOptions: SponsorshipFormSharedStepProps['genderOptions'];
  values: CatSponsorshipFormStoreValues | SpecialSponsorshipFormStoreValues;
  updateValues: (
    payload: CatSponsorshipFormAnyStepFields | SpecialSponsorshipFormAnyStepFields
  ) => void;
}

export const GifteeDetailsStep: FC<GifteeDetailsStepProps> = ({
  onPrev,
  onNext,
  countryOptions,
  genderOptions,
  values,
  updateValues,
}) => {
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
