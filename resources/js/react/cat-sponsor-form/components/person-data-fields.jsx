import React from 'react';
import { useController, useFormContext } from 'react-hook-form';
import { Input } from '../../components/input';
import { Error } from '../../components/error';
import { genderOptions } from '../model';
import { BoxOption } from '../../components/box-option';
import { Select } from '../../components/select';
import { useGlobalState } from '../hooks/use-global-state';

export function PersonDataFields({ prefix, countryList }) {
  const { state } = useGlobalState();

  const {
    formState: { errors },
    control,
  } = useFormContext();

  const countryOptions = Object.keys(countryList.options).map((countryCode) => ({
    key: countryCode,
    label: countryList.options[countryCode],
    value: countryCode,
  }));

  const Field = {
    EMAIL: `${prefix}_email`,
    FIRST_NAME: `${prefix}_first_name`,
    LAST_NAME: `${prefix}_last_name`,
    GENDER: `${prefix}_gender`,
    ADDRESS: `${prefix}_address`,
    ZIP_CODE: `${prefix}_zip_code`,
    CITY: `${prefix}_city`,
    COUNTRY: `${prefix}_country`,
  };

  const { field: emailControl } = useController({
    name: Field.EMAIL,
    control,
    defaultValue: state.formData[Field.EMAIL],
  });
  const { field: firstNameControl } = useController({
    name: Field.FIRST_NAME,
    control,
    defaultValue: state.formData[Field.FIRST_NAME],
  });
  const { field: lastNameControl } = useController({
    name: Field.LAST_NAME,
    control,
    defaultValue: state.formData[Field.LAST_NAME],
  });
  const { field: genderControl } = useController({
    name: Field.GENDER,
    control,
    defaultValue: state.formData[Field.GENDER],
  });
  const { field: addressControl } = useController({
    name: Field.ADDRESS,
    control,
    defaultValue: state.formData[Field.ADDRESS],
  });
  const { field: zipCodeControl } = useController({
    name: Field.ZIP_CODE,
    control,
    defaultValue: state.formData[Field.ZIP_CODE],
  });
  const { field: cityControl } = useController({
    name: Field.CITY,
    control,
    defaultValue: state.formData[Field.CITY],
  });
  const { field: countryControl } = useController({
    name: Field.COUNTRY,
    control,
    defaultValue: state.formData[Field.COUNTRY],
  });

  return (
    <>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Email</div>
        <Input onChange={emailControl.onChange} hasError={!!errors[Field.EMAIL]} />
        {errors[Field.EMAIL] && <Error>{errors[Field.EMAIL].message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Ime</div>
        <Input onChange={firstNameControl.onChange} hasError={!!errors[Field.FIRST_NAME]} />
        {errors[Field.FIRST_NAME] && <Error>{errors[Field.FIRST_NAME].message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Priimek</div>
        <Input onChange={lastNameControl.onChange} hasError={!!errors[Field.LAST_NAME]} />
        {errors[Field.LAST_NAME] && <Error>{errors[Field.LAST_NAME].message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Spol</div>
        <div className="flex space-x-4">
          {genderOptions.map((option) => (
            <BoxOption
              key={option.value}
              label={option.label}
              onClick={() => {
                genderControl.onChange(option.value);
              }}
              isSelected={genderControl.value === option.value}
            />
          ))}
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Ulica in hišna številka</div>
        <Input onChange={addressControl.onChange} hasError={!!errors[Field.ADDRESS]} />
        {errors[Field.ADDRESS] && <Error>{errors[Field.ADDRESS].message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Poštna številka</div>
        <Input onChange={zipCodeControl.onChange} hasError={!!errors[Field.ZIP_CODE]} />
        {errors[Field.ZIP_CODE] && <Error>{errors[Field.ZIP_CODE].message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Kraj</div>
        <Input onChange={cityControl.onChange} hasError={!!errors[Field.CITY]} />
        {errors[Field.CITY] && <Error>{errors[Field.CITY].message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Država</div>
        <Select
          options={countryOptions}
          selectedValue={countryControl.value}
          onChange={countryControl.onChange}
        />
      </div>
    </>
  );
}
