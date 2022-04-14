import React, { useState, useRef } from 'react';
import { useForm, useController } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from './updateFormDataAction';
import { BoxOption } from '../components/box-option';

export function Step1({ onNext }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });

  const {
    register,
    handleSubmit,
    control,
    watch,
    formState: { errors },
    getValues,
  } = useForm({
    defaultValues: state.formData,
    mode: 'all',
  });

  const { field: monthlyAmountControl } = useController({
    name: 'monthly_amount',
    control,
    rules: {
      validate: (value) => {
        if (!value) {
          return 'Polje je obvezno.';
        }

        if (!/^\d+$/.test(value)) {
          return 'Vrednost mora biti polna številka (npr. 5).';
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
          return 'Polje je obvezno.';
        }

        if (!/^\d+$/.test(value)) {
          return 'Vrednost mora biti polna številka (npr. 5).';
        }

        if (Number(value) < 1) {
          return 'Vrednost mora biti višja od 1.';
        }

        return undefined;
      },
    },
  });

  const [isCustomAmount, setIsCustomAmount] = useState(false);
  const [isCustomDuration, setIsCustomDuration] = useState(false);

  const customAmountInput = useRef(null);
  const customDurationInput = useRef(null);

  const isGift = watch('is_gift');
  const selectedAmount = watch('monthly_amount');
  const selectedDuration = watch('duration');

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
        <div className="mb-form-group-label">Komu je botrstvo namenjeno?</div>
        <div className="flex space-x-4">
          <label htmlFor="is_gift_no" className="mb-inline-selectable-label">
            <input
              {...register('is_gift')}
              type="radio"
              name="is_gift"
              value="no"
              id="is_gift_no"
            />
            <span>Boter bom jaz</span>
          </label>
          <label htmlFor="is_gift_yes" className="mb-inline-selectable-label">
            <input
              {...register('is_gift')}
              type="radio"
              name="is_gift"
              value="yes"
              id="is_gift_yes"
            />
            <span>Botrstvo želim podariti</span>
          </label>
        </div>
      </div>

      <div className="mb-form-group">
        <div className="mb-form-group-label">Mesečni znesek</div>
        <div className="flex space-x-4">
          {monthlyAmountOptions.map((option) => (
            <BoxOption
              key={option.value}
              onClick={() => {
                setIsCustomAmount(false);
                monthlyAmountControl.onChange(option.value);
                customAmountInput.current.value = '';
              }}
              isSelected={!isCustomAmount && option.value === selectedAmount}
            >
              {option.label}
            </BoxOption>
          ))}
          <input
            ref={customAmountInput}
            className="mb-input"
            type="text"
            placeholder="Poljubni znesek v evrih"
            onChange={(event) => {
              setIsCustomAmount(true);
              monthlyAmountControl.onChange(event);
            }}
          />
          {errors.monthly_amount && <span>{errors.monthly_amount.message}</span>}
        </div>
      </div>

      {isGift === 'yes' && (
        <div className="mb-form-group">
          <div className="mb-form-group-label">Trajanje</div>
          <div className="flex space-x-2">
            {durationOptions.map((option) => (
              <BoxOption
                key={option.value}
                onClick={() => {
                  setIsCustomDuration(false);
                  durationControl.onChange(option.value);
                  customDurationInput.current.value = '';
                }}
                isSelected={!isCustomDuration && option.value === selectedDuration}
              >
                {option.label}
              </BoxOption>
            ))}
            <input
              ref={customDurationInput}
              className="mb-input"
              type="text"
              placeholder="Poljubno število mesecev"
              onChange={(event) => {
                setIsCustomDuration(true);
                durationControl.onChange(event);
              }}
            />
            {errors.duration && <span>{errors.duration.message}</span>}
          </div>
        </div>
      )}

      <div className="mb-form-group">
        <label htmlFor="wants_direct_debit" className="mb-inline-selectable-label">
          <input {...register('wants_direct_debit')} type="checkbox" id="wants_direct_debit" />
          <span>Želim, da mi pošljete informacije v zvezi z ureditvijo trajnika</span>
        </label>
      </div>

      <div className="mb-form-group">
        <label htmlFor="is_anonymous" className="mb-inline-selectable-label">
          <input {...register('is_anonymous')} type="checkbox" id="is_anonymous" />
          <span>Botrstvo naj bo anonimno</span>
        </label>
      </div>

      <button type="submit" className="mb-btn mb-btn-primary">
        Naprej
      </button>
    </form>
  );
}
