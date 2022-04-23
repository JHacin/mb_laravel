import React, { useState, useRef } from 'react';
import { useForm, useController } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import clsx from 'clsx';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { updateFormDataAction } from './updateFormDataAction';
import { BoxOption } from '../components/box-option';
import { Input } from '../components/input';
import { Checkbox } from '../components/checkbox';
import { Error } from '../components/error';
import { FORM_MODE } from './constants';
import { durationOptions, isGiftOptions, monthlyAmountOptions } from './model';
import { useGlobalSync } from './hooks/use-global-sync'

export function SponsorshipParamsStep({ onNext }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });

  const validationSchema = yup.object({
    is_gift: yup.boolean(),
    monthly_amount: yup.number().integer().min(5).required(),
    duration: yup.number().when('is_gift', {
      is: true,
      then: (schema) => schema.integer().positive().required(),
      otherwise: (schema) => schema.strip(),
    }),
    wants_direct_debit: yup.boolean(),
    is_anonymous: yup.boolean(),
  });

  const {
    handleSubmit,
    control,
    watch,
    formState: { errors, isValid },
  } = useForm({
    defaultValues: state.formData,
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  const { field: isGiftControl } = useController({ name: 'is_gift', control });
  const { field: monthlyAmountControl } = useController({ name: 'monthly_amount', control });
  const { field: durationControl } = useController({ name: 'duration', control });
  const { field: wantsDirectDebitControl } = useController({ name: 'wants_direct_debit', control });
  const { field: isAnonymousControl } = useController({ name: 'is_anonymous', control });

  const [isCustomAmount, setIsCustomAmount] = useState(false);
  const [isCustomDuration, setIsCustomDuration] = useState(false);

  const customAmountInput = useRef(null);
  const customDurationInput = useRef(null);

  const onSubmit = (data) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  useGlobalSync({ watch })

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