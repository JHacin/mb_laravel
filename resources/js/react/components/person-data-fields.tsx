import React, { FC } from 'react';
import { useController, useFormContext } from 'react-hook-form';
import { SelectOption } from '../types';
import { BoxOption } from './box-option';
import { HookFormTextField } from './hook-form-textfield';
import {
  CatSponsorshipFormStoreValues,
  GifteeDetailsStepFields,
  PayerDetailsStepFields,
} from '../cat-sponsor-form/types';
import { HookFormSelect } from './hook-form-select';
import { SpecialSponsorshipFormStoreValues } from '../special-sponsorship-form/types'

interface PersonDataFieldsProps {
  prefix: 'payer' | 'giftee';
  countryOptions: SelectOption[];
  genderOptions: SelectOption[];
  storeValues: CatSponsorshipFormStoreValues | SpecialSponsorshipFormStoreValues;
}

export const PersonDataFields: FC<PersonDataFieldsProps> = ({
  prefix,
  countryOptions,
  genderOptions,
  storeValues,
}) => {
  const { control } = useFormContext<PayerDetailsStepFields | GifteeDetailsStepFields>();

  const Field: Record<string, keyof PayerDetailsStepFields | keyof GifteeDetailsStepFields> = {
    EMAIL: `${prefix}_email`,
    FIRST_NAME: `${prefix}_first_name`,
    LAST_NAME: `${prefix}_last_name`,
    GENDER: `${prefix}_gender`,
    ADDRESS: `${prefix}_address`,
    ZIP_CODE: `${prefix}_zip_code`,
    CITY: `${prefix}_city`,
    COUNTRY: `${prefix}_country`,
  };

  const autoCompletePrefix = prefix === 'giftee' ? 'new-' : '';

  const emailControl = useController({
    name: Field.EMAIL,
    control,
    defaultValue: storeValues[Field.EMAIL],
  });
  const firstNameControl = useController({
    name: Field.FIRST_NAME,
    control,
    defaultValue: storeValues[Field.FIRST_NAME],
  });
  const lastNameControl = useController({
    name: Field.LAST_NAME,
    control,
    defaultValue: storeValues[Field.LAST_NAME],
  });
  const genderControl = useController({
    name: Field.GENDER,
    control,
    defaultValue: storeValues[Field.GENDER],
  });
  const addressControl = useController({
    name: Field.ADDRESS,
    control,
    defaultValue: storeValues[Field.ADDRESS],
  });
  const zipCodeControl = useController({
    name: Field.ZIP_CODE,
    control,
    defaultValue: storeValues[Field.ZIP_CODE],
  });
  const cityControl = useController({
    name: Field.CITY,
    control,
    defaultValue: storeValues[Field.CITY],
  });
  const countryControl = useController({
    name: Field.COUNTRY,
    control,
    defaultValue: storeValues[Field.COUNTRY],
  });

  return (
    <>
      <div className="mb-form-group">
        <div className="mb-form-group-label">E-mail naslov*</div>
        <HookFormTextField control={emailControl} autoComplete={`${autoCompletePrefix}email`} />
      </div>

      <div className="mb-form-group grid sm:grid-cols-5 gap-4">
        <div className="sm:col-span-2">
          <div className="mb-form-group-label">Ime*</div>
          <HookFormTextField
            control={firstNameControl}
            autoComplete={`${autoCompletePrefix}given-name`}
          />
        </div>
        <div className="sm:col-span-3">
          <div className="mb-form-group-label">Priimek*</div>
          <HookFormTextField
            control={lastNameControl}
            autoComplete={`${autoCompletePrefix}family-name`}
          />
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Spol*</div>
        <div className="flex space-x-4">
          {genderOptions.map((option) => (
            <BoxOption
              key={String(option.value)}
              label={option.label}
              onClick={() => {
                genderControl.field.onChange(option.value);
              }}
              isSelected={genderControl.field.value === option.value}
            />
          ))}
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Naslov*</div>
        <HookFormTextField
          control={addressControl}
          autoComplete={`${autoCompletePrefix}street-address`}
        />
      </div>

      <div className="mb-form-group grid sm:grid-cols-5 gap-4">
        <div className="sm:col-span-2">
          <div className="mb-form-group-label">Poštna številka*</div>
          <HookFormTextField
            control={zipCodeControl}
            autoComplete={`${autoCompletePrefix}postal-code`}
          />
        </div>
        <div className="sm:col-span-3">
          <div className="mb-form-group-label">Kraj*</div>
          <HookFormTextField
            control={cityControl}
            autoComplete={`${autoCompletePrefix}address-level2`}
          />
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Država*</div>
        <HookFormSelect options={countryOptions} control={countryControl} />
      </div>
    </>
  );
};
