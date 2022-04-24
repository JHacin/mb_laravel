import React from 'react';
import { useForm, useController } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { updateFormDataAction } from './updateFormDataAction';
import { Input } from '../components/input';
import { Error } from '../components/error';
import { FORM_MODE } from './constants';
import { BoxOption } from '../components/box-option';
import { Select } from '../components/select';
import { genderOptions } from './model';
import { useGlobalSync } from './hooks/use-global-sync';

export function GifteeDetailsStep({ onPrev, onNext, countryList }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });

  const validationSchema = yup.object({
    giftee_email: yup.string().email().required(),
    giftee_first_name: yup.string().required(),
    giftee_last_name: yup.string().required(),
    giftee_gender: yup.string().required(),
    giftee_address: yup.string().required(),
    giftee_zip_code: yup.string().required(),
    giftee_city: yup.string().required(),
    giftee_country: yup.string().required(),
  });

  const {
    handleSubmit,
    formState: { errors },
    watch,
    control,
  } = useForm({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  const countryOptions = Object.keys(countryList.options).map((countryCode) => ({
    key: countryCode,
    label: countryList.options[countryCode],
    value: countryCode,
  }));

  const { field: gifteeEmailControl } = useController({
    name: 'giftee_email',
    control,
    defaultValue: state.formData.giftee_email,
  });
  const { field: gifteeFirstNameControl } = useController({
    name: 'giftee_first_name',
    control,
    defaultValue: state.formData.giftee_first_name,
  });
  const { field: gifteeLastNameControl } = useController({
    name: 'giftee_last_name',
    control,
    defaultValue: state.formData.giftee_last_name,
  });
  const { field: gifteeGenderControl } = useController({
    name: 'giftee_gender',
    control,
    defaultValue: state.formData.giftee_gender,
  });
  const { field: gifteeAddressControl } = useController({
    name: 'giftee_address',
    control,
    defaultValue: state.formData.giftee_address,
  });
  const { field: gifteeZipcodeControl } = useController({
    name: 'giftee_zip_code',
    control,
    defaultValue: state.formData.giftee_zip_code,
  });
  const { field: gifteeCityControl } = useController({
    name: 'giftee_city',
    control,
    defaultValue: state.formData.giftee_city,
  });
  const { field: gifteeCountryControl } = useController({
    name: 'giftee_country',
    control,
    defaultValue: state.formData.giftee_country,
  });

  const onSubmit = (data) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  useGlobalSync({ watch });

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Email</div>
        <Input onChange={gifteeEmailControl.onChange} hasError={!!errors.giftee_email} />
        {errors.giftee_email && <Error>{errors.giftee_email.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Ime</div>
        <Input onChange={gifteeFirstNameControl.onChange} hasError={!!errors.giftee_first_name} />
        {errors.giftee_first_name && <Error>{errors.giftee_first_name.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Priimek</div>
        <Input onChange={gifteeLastNameControl.onChange} hasError={!!errors.giftee_last_name} />
        {errors.giftee_last_name && <Error>{errors.giftee_last_name.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Spol</div>
        <div className="flex space-x-4">
          {genderOptions.map((option) => (
            <BoxOption
              key={option.value}
              label={option.label}
              onClick={() => {
                gifteeGenderControl.onChange(option.value);
              }}
              isSelected={gifteeGenderControl.value === option.value}
            />
          ))}
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Ulica in hišna številka</div>
        <Input onChange={gifteeAddressControl.onChange} hasError={!!errors.giftee_address} />
        {errors.giftee_address && <Error>{errors.giftee_address.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Poštna številka</div>
        <Input onChange={gifteeZipcodeControl.onChange} hasError={!!errors.giftee_zip_code} />
        {errors.giftee_zip_code && <Error>{errors.giftee_zip_code.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Kraj</div>
        <Input onChange={gifteeCityControl.onChange} hasError={!!errors.giftee_city} />
        {errors.giftee_city && <Error>{errors.giftee_city.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Država</div>
        <Select
          options={countryOptions}
          selectedValue={gifteeCountryControl.value}
          onChange={gifteeCountryControl.onChange}
        />
      </div>

      <button type="button" className="mb-btn mb-btn-secondary" onClick={onPrev}>
        Nazaj
      </button>

      <button type="submit" className="mb-btn mb-btn-primary">
        Naprej
      </button>
    </form>
  );
}
