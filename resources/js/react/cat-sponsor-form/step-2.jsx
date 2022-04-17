import React from 'react';
import { useForm, useController } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from './updateFormDataAction';
import { Input } from '../components/input';
import { Error } from '../components/error';
import { errorMessages } from './validation';
import { FORM_MODE } from './constants';
import { BoxOption } from '../components/box-option';
import { Select } from '../components/select';

export function Step2({ onPrev, onNext, countryList }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });
  const {
    handleSubmit,
    formState: { errors },
    watch,
    control,
  } = useForm({
    defaultValues: state.formData,
    mode: FORM_MODE,
  });

  const isGift = state.formData.is_gift;

  const { field: payerEmailControl } = useController({
    name: 'payer_email',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: payerFirstNameControl } = useController({
    name: 'payer_first_name',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: payerLastNameControl } = useController({
    name: 'payer_last_name',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: payerGenderControl } = useController({
    name: 'payer_gender',
    control,
  });

  const genderOptions = [
    { label: 'Ženska', value: 'female' },
    { label: 'Moški', value: 'male' },
  ];

  const { field: payerAddressControl } = useController({
    name: 'payer_address',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: payerZipcodeControl } = useController({
    name: 'payer_zip_code',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: payerCityControl } = useController({
    name: 'payer_city',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: payerCountryControl } = useController({
    name: 'payer_country',
    control,
  });

  const countryOptions = Object.keys(countryList.options).map((countryCode) => ({
    key: countryCode,
    label: countryList.options[countryCode],
    value: countryCode,
  }));

  const { field: gifteeEmailControl } = useController({
    name: 'giftee_email',
    control,
    rules: {
      validate: (value) => {
        if (!isGift) {
          return undefined;
        }

        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: gifteeFirstNameControl } = useController({
    name: 'giftee_first_name',
    control,
    rules: {
      validate: (value) => {
        if (!isGift) {
          return undefined;
        }

        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: gifteeLastNameControl } = useController({
    name: 'giftee_last_name',
    control,
    rules: {
      validate: (value) => {
        if (!isGift) {
          return undefined;
        }

        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: gifteeGenderControl } = useController({
    name: 'payer_gender',
    control,
  });

  const { field: gifteeAddressControl } = useController({
    name: 'giftee_address',
    control,
    rules: {
      validate: (value) => {
        if (!isGift) {
          return undefined;
        }

        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: gifteeZipcodeControl } = useController({
    name: 'giftee_zip_code',
    control,
    rules: {
      validate: (value) => {
        if (!isGift) {
          return undefined;
        }

        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: gifteeCityControl } = useController({
    name: 'giftee_city',
    control,
    rules: {
      validate: (value) => {
        if (!isGift) {
          return undefined;
        }

        if (!value) {
          return errorMessages.required;
        }

        return undefined;
      },
    },
  });

  const { field: gifteeCountryControl } = useController({
    name: 'giftee_country',
    control,
  });

  const onSubmit = (data) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  React.useEffect(() => {
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

      {isGift && (
        <div>
          <div>
            <strong>(?) STEP 3 - Podatki obdarovanca</strong>
          </div>
          <div className="mb-form-group">
            <div className="mb-form-group-label">Email</div>
            <Input onChange={gifteeEmailControl.onChange} hasError={!!errors.giftee_email} />
            {errors.giftee_email && <Error>{errors.giftee_email.message}</Error>}
          </div>

          <div className="mb-form-group">
            <div className="mb-form-group-label">Ime</div>
            <Input
              onChange={gifteeFirstNameControl.onChange}
              hasError={!!errors.giftee_first_name}
            />
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
        </div>
      )}

      <button type="button" className="mb-btn mb-btn-secondary" onClick={onPrev}>
        Nazaj
      </button>

      <button type="submit" className="mb-btn mb-btn-primary">
        Naprej
      </button>
    </form>
  );
}
