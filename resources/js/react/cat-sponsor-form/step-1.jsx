import React, { useState, useRef } from 'react';
import { useForm, useController } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import clsx from 'clsx';
import { updateFormDataAction } from './updateFormDataAction';
import { BoxOption } from '../components/box-option';
import { Input } from '../components/input';
import { Checkbox } from '../components/checkbox';
import { errorMessages, isNumber } from './validation';
import { Error } from '../components/error';
import { FORM_MODE } from './constants';

export function Step1({ onNext }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });

  const {
    handleSubmit,
    control,
    watch,
    formState: { errors, isValid },
    getValues,
  } = useForm({
    defaultValues: state.formData,
    mode: FORM_MODE,
  });

  const { field: isGiftControl } = useController({
    name: 'is_gift',
    control,
  });

  const { field: monthlyAmountControl } = useController({
    name: 'monthly_amount',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return errorMessages.required;
        }

        if (!isNumber(value)) {
          return errorMessages.mustBeFullNumber;
        }

        if (Number(value) < 5) {
          return 'Znesek ne sme biti manjši od 5€.';
        }

        return undefined;
      },
    },
  });

  const { field: durationControl } = useController({
    name: 'duration',
    control,
    rules: {
      validate: (value) => {
        if (getValues('is_gift') === 'no') {
          return undefined;
        }

        if (!value) {
          return errorMessages.required;
        }

        if (!isNumber(value)) {
          return 'Vrednost mora biti polna številka (npr. 5).';
        }

        if (Number(value) < 1) {
          return 'Vrednost mora biti višja od 1.';
        }

        return undefined;
      },
    },
  });

  const { field: wantsDirectDebitControl } = useController({
    name: 'wants_direct_debit',
    control,
  });

  const { field: isAnonymousControl } = useController({
    name: 'is_anonymous',
    control,
  });

  const [isCustomAmount, setIsCustomAmount] = useState(false);
  const [isCustomDuration, setIsCustomDuration] = useState(false);

  const customAmountInput = useRef(null);
  const customDurationInput = useRef(null);

  const isGiftOptions = [
    { label: 'Boter bom jaz', value: false },
    { label: 'Botrstvo želim podariti', value: true },
  ];

  const monthlyAmountOptions = [
    { label: '5€', value: 5 },
    { label: '10€', value: 10 },
    { label: '20€', value: 20 },
    { label: '50€', value: 50 },
  ];

  const durationOptions = [
    { label: '1 mesec', value: 1 },
    { label: '3 meseci', value: 3 },
    { label: '6 mesecev', value: 6 },
    { label: '12 mesecev', value: 12 },
  ];

  const onSubmit = (data) => {
    const payload = {
      ...data,
      monthly_amount: Number(data.monthly_amount),
      duration: Number(data.duration),
    };

    console.log('Payload: ', payload);

    actions.updateFormDataAction(payload);
    onNext();
  };

  React.useEffect(() => {
    const subscription = watch((value) => console.log(JSON.stringify(value, null, '\t')));
    return () => subscription.unsubscribe();
  }, [watch]);

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Komu je botrstvo namenjeno?</div>
        <div className="flex space-x-4">
          {isGiftOptions.map((option) => (
            <BoxOption
              key={option.value}
              label={option.label}
              onClick={() => {
                isGiftControl.onChange(option.value);
              }}
              isSelected={isGiftControl.value === option.value}
            />
          ))}
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Mesečni znesek</div>
        <div className="flex space-x-4">
          {monthlyAmountOptions.map((option) => (
            <BoxOption
              key={option.value}
              label={option.label}
              onClick={() => {
                setIsCustomAmount(false);
                monthlyAmountControl.onChange(option.value);
                customAmountInput.current.value = '';
              }}
              isSelected={!isCustomAmount && option.value === monthlyAmountControl.value}
            />
          ))}
          <Input
            ref={customAmountInput}
            isInvalid={!!errors.monthly_amount}
            placeholder="Poljubni znesek v evrih"
            onChange={(event) => {
              setIsCustomAmount(true);
              monthlyAmountControl.onChange(event);
            }}
          />
          {errors.monthly_amount && <Error>{errors.monthly_amount.message}</Error>}
        </div>
      </div>

      {isGiftControl.value === true && (
        <div className="mb-form-group">
          <div className="mb-form-group-label">Trajanje</div>
          <div className="flex space-x-2">
            {durationOptions.map((option) => (
              <BoxOption
                key={option.value}
                label={option.label}
                onClick={() => {
                  setIsCustomDuration(false);
                  durationControl.onChange(option.value);
                  customDurationInput.current.value = '';
                }}
                isSelected={!isCustomDuration && option.value === durationControl.value}
              />
            ))}
            <Input
              ref={customDurationInput}
              isInvalid={!!errors.duration}
              placeholder="Poljubno število mesecev"
              onChange={(event) => {
                setIsCustomDuration(true);
                durationControl.onChange(event);
              }}
            />
            {errors.duration && <Error>{errors.duration.message}</Error>}
          </div>
        </div>
      )}

      <div className="mb-form-group">
        <Checkbox
          label="Želim, da mi pošljete informacije v zvezi z ureditvijo trajnika"
          id="wants_direct_debit"
          onChange={wantsDirectDebitControl.onChange}
        />
      </div>

      <div className="mb-form-group">
        <Checkbox
          label="Botrstvo naj bo anonimno"
          id="is_anonymous"
          onChange={isAnonymousControl.onChange}
        />
      </div>

      <button
        type="submit"
        className={clsx('mb-btn', isValid && 'mb-btn-primary', !isValid && 'mb-btn-disabled')}
      >
        Naprej
      </button>
    </form>
  );
}
