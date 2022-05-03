import React, { FC, useState } from 'react';
import { useForm, useController } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { BoxOption } from '../../components/box-option';
import { Input } from '../../components/input';
import { Checkbox } from '../../components/checkbox';
import { Error } from '../../components/error';
import { AMOUNT_OPTIONS, DURATION_OPTIONS, FORM_MODE, IS_GIFT_OPTIONS } from '../constants';
import { useGlobalFormDataUpdate } from '../hooks/use-global-form-data-update';
import { useGlobalState } from '../hooks/use-global-state';
import { SubmitButton } from '../components/submit-button';
import { ButtonRow } from '../components/button-row';
import { SharedStepProps, SponsorshipParamsStepFields } from '../types';
import { YupValidationSchemaShape } from '../../types';

export const SponsorshipParamsStep: FC<SharedStepProps> = ({ onNext }) => {
  const { actions, state } = useGlobalState();

  const validationSchema = yup.object<YupValidationSchemaShape<SponsorshipParamsStepFields>>({
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
    formState: { errors },
  } = useForm<SponsorshipParamsStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useGlobalFormDataUpdate({ watch, actions });

  const { field: isGiftControl } = useController({
    name: 'is_gift',
    control,
    defaultValue: state.formData.is_gift,
  });
  const { field: amountControl } = useController({
    name: 'monthly_amount',
    control,
    defaultValue: state.formData.monthly_amount,
  });
  const { field: durationControl } = useController({
    name: 'duration',
    control,
    defaultValue: state.formData.duration,
  });
  const { field: wantsDirectDebitControl } = useController({
    name: 'wants_direct_debit',
    control,
    defaultValue: state.formData.wants_direct_debit,
  });
  const { field: isAnonymousControl } = useController({
    name: 'is_anonymous',
    control,
    defaultValue: state.formData.is_anonymous,
  });

  const defaultAmountIsCustom = !AMOUNT_OPTIONS.some((o) => o.value === amountControl.value);
  const [isCustomAmount, setIsCustomAmount] = useState(defaultAmountIsCustom);

  const defaultDurationIsCustom = !DURATION_OPTIONS.some((o) => o.value === durationControl.value);
  const [isCustomDuration, setIsCustomDuration] = useState(defaultDurationIsCustom);

  const onSubmit = (data: SponsorshipParamsStepFields) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Komu je botrstvo namenjeno?</div>
        <div className="flex space-x-4">
          {IS_GIFT_OPTIONS.map((option) => (
            <BoxOption
              key={option.key}
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
          {AMOUNT_OPTIONS.map((option) => (
            <BoxOption
              key={option.key}
              label={option.label}
              onClick={() => {
                setIsCustomAmount(false);
                amountControl.onChange(option.value);
              }}
              isSelected={!isCustomAmount && option.value === amountControl.value}
            />
          ))}
          <Input
            ref={amountControl.ref}
            value={isCustomAmount ? amountControl.value : ''}
            isInvalid={!!errors.monthly_amount}
            placeholder="Poljubni znesek v evrih"
            onChange={(event) => {
              setIsCustomAmount(true);
              amountControl.onChange(event);
            }}
          />
          {errors.monthly_amount && <Error>{errors.monthly_amount.message}</Error>}
        </div>
      </div>

      {isGiftControl.value === true && (
        <div className="mb-form-group">
          <div className="mb-form-group-label">Trajanje</div>
          <div className="flex space-x-2">
            {DURATION_OPTIONS.map((option) => (
              <BoxOption
                key={option.key}
                label={option.label}
                onClick={() => {
                  setIsCustomDuration(false);
                  durationControl.onChange(option.value);
                }}
                isSelected={!isCustomDuration && option.value === durationControl.value}
              />
            ))}
            <Input
              value={isCustomDuration ? durationControl.value : ''}
              ref={durationControl.ref}
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
          value={wantsDirectDebitControl.value}
          ref={wantsDirectDebitControl.ref}
        />
      </div>

      <div className="mb-form-group">
        <Checkbox
          label="Botrstvo naj bo anonimno"
          id="is_anonymous"
          onChange={isAnonymousControl.onChange}
          value={isAnonymousControl.value}
          ref={isAnonymousControl.ref}
        />
      </div>

      <ButtonRow>
        <SubmitButton>Naprej</SubmitButton>
      </ButtonRow>
    </form>
  );
};
