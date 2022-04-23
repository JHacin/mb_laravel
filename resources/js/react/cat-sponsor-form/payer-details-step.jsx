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

export function PayerDetailsStep({ onPrev, onNext, countryList }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });

  const validationSchema = yup.object({
    payer_email: yup.string().email().required(),
    payer_first_name: yup.string().required(),
    payer_last_name: yup.string().required(),
    payer_gender: yup.string().required(),
    payer_address: yup.string().required(),
    payer_zip_code: yup.string().required(),
    payer_city: yup.string().required(),
    payer_country: yup.string().required(),
  });

  const {
    handleSubmit,
    formState: { errors },
    watch,
    control,
  } = useForm({
    defaultValues: state.formData,
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  const countryOptions = Object.keys(countryList.options).map((countryCode) => ({
    key: countryCode,
    label: countryList.options[countryCode],
    value: countryCode,
  }));

  const { field: payerEmailControl } = useController({ name: 'payer_email', control });
  const { field: payerFirstNameControl } = useController({ name: 'payer_first_name', control });
  const { field: payerLastNameControl } = useController({ name: 'payer_last_name', control });
  const { field: payerGenderControl } = useController({ name: 'payer_gender', control });
  const { field: payerAddressControl } = useController({ name: 'payer_address', control });
  const { field: payerZipcodeControl } = useController({ name: 'payer_zip_code', control });
  const { field: payerCityControl } = useController({ name: 'payer_city', control });
  const { field: payerCountryControl } = useController({ name: 'payer_country', control });

  const onSubmit = (data) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  React.useEffect(() => {
    // eslint-disable-next-line no-console
    const subscription = watch((value) => console.log(JSON.stringify(value, null, '\t')));
    return () => subscription.unsubscribe();
  }, [watch]);

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Email</div>
        <Input onChange={payerEmailControl.onChange} hasError={!!errors.payer_email} />
        {errors.payer_email && <Error>{errors.payer_email.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Ime</div>
        <Input onChange={payerFirstNameControl.onChange} hasError={!!errors.payer_first_name} />
        {errors.payer_first_name && <Error>{errors.payer_first_name.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Priimek</div>
        <Input onChange={payerLastNameControl.onChange} hasError={!!errors.payer_last_name} />
        {errors.payer_last_name && <Error>{errors.payer_last_name.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Spol</div>
        <div className="flex space-x-4">
          {genderOptions.map((option) => (
            <BoxOption
              key={option.value}
              label={option.label}
              onClick={() => {
                payerGenderControl.onChange(option.value);
              }}
              isSelected={payerGenderControl.value === option.value}
            />
          ))}
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Ulica in hišna številka</div>
        <Input onChange={payerAddressControl.onChange} hasError={!!errors.payer_address} />
        {errors.payer_address && <Error>{errors.payer_address.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Poštna številka</div>
        <Input onChange={payerZipcodeControl.onChange} hasError={!!errors.payer_zip_code} />
        {errors.payer_zip_code && <Error>{errors.payer_zip_code.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Kraj</div>
        <Input onChange={payerCityControl.onChange} hasError={!!errors.payer_city} />
        {errors.payer_city && <Error>{errors.payer_city.message}</Error>}
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Država</div>
        <Select
          options={countryOptions}
          selectedValue={payerCountryControl.value}
          onChange={payerCountryControl.onChange}
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
