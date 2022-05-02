import React, { FC } from 'react';
import { useController, useFormContext } from 'react-hook-form';
import {
  GifteeDetailsStepFields,
  PayerDetailsStepFields,
  PersonType,
  SelectOption,
} from '../../types';
import { BoxOption } from '../../components/box-option';
import { Select } from '../../components/select';
import { useGlobalState } from '../hooks/use-global-state';
import { HookFormTextField } from './hook-form-text-field';

interface PersonDataFieldsProps {
  prefix: PersonType;
  countryOptions: SelectOption[];
  genderOptions: SelectOption[];
}

export const PersonDataFields: FC<PersonDataFieldsProps> = ({
  prefix,
  countryOptions,
  genderOptions,
}) => {
  const { state } = useGlobalState();
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
    defaultValue: state.formData[Field.EMAIL],
  });
  const firstNameControl = useController({
    name: Field.FIRST_NAME,
    control,
    defaultValue: state.formData[Field.FIRST_NAME],
  });
  const lastNameControl = useController({
    name: Field.LAST_NAME,
    control,
    defaultValue: state.formData[Field.LAST_NAME],
  });
  const genderControl = useController({
    name: Field.GENDER,
    control,
    defaultValue: state.formData[Field.GENDER],
  });
  const addressControl = useController({
    name: Field.ADDRESS,
    control,
    defaultValue: state.formData[Field.ADDRESS],
  });
  const zipCodeControl = useController({
    name: Field.ZIP_CODE,
    control,
    defaultValue: state.formData[Field.ZIP_CODE],
  });
  const cityControl = useController({
    name: Field.CITY,
    control,
    defaultValue: state.formData[Field.CITY],
  });
  const countryControl = useController({
    name: Field.COUNTRY,
    control,
    defaultValue: state.formData[Field.COUNTRY],
  });

  return (
    <>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Email</div>
        <HookFormTextField control={emailControl} autoComplete={`${autoCompletePrefix}email`} />
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Ime</div>
        <HookFormTextField
          control={firstNameControl}
          autoComplete={`${autoCompletePrefix}given-name`}
        />
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Priimek</div>
        <HookFormTextField
          control={lastNameControl}
          autoComplete={`${autoCompletePrefix}family-name`}
        />
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Spol</div>
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
        <div className="mb-form-group-label">Ulica in hišna številka</div>
        <HookFormTextField
          control={addressControl}
          autoComplete={`${autoCompletePrefix}street-address`}
        />
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Poštna številka</div>
        <HookFormTextField
          control={zipCodeControl}
          autoComplete={`${autoCompletePrefix}postal-code`}
        />
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Kraj</div>
        <HookFormTextField
          control={cityControl}
          autoComplete={`${autoCompletePrefix}address-level2`}
        />
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Država</div>
        <Select
          options={countryOptions}
          value={countryControl.field.value}
          onChange={countryControl.field.onChange}
        />
      </div>
    </>
  );
};
