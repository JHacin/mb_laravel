import React, { FC, useState } from 'react';
import { useForm, useController } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { BoxOption } from '../../components/box-option';
import { Input } from '../../components/input';
import { Error } from '../../components/error';
import {
  AMOUNT_OPTIONS,
  REQUESTED_DURATION_OPTIONS,
  FORM_MODE,
  IS_GIFT_OPTIONS,
} from '../constants';
import { useGlobalFormDataUpdate } from '../hooks/use-global-form-data-update';
import { useGlobalState } from '../hooks/use-global-state';
import { SubmitButton } from '../components/submit-button';
import { ButtonRow } from '../components/button-row';
import { SharedStepProps, SponsorshipParamsStepFields } from '../types';
import { YupValidationSchemaShape } from '../../types';
import { HookFormCheckbox } from '../components/hook-form-checkbox';

export const SponsorshipParamsStep: FC<SharedStepProps> = ({ onNext, validationConfig }) => {
  const { actions, state } = useGlobalState();

  const validationSchema = yup.object<YupValidationSchemaShape<SponsorshipParamsStepFields>>({
    is_gift: yup.boolean(),
    monthly_amount: yup
      .number()
      .integer()
      .min(validationConfig.monthly_amount_min)
      .max(validationConfig.number_max)
      .required(),
    requested_duration: yup.number().when('is_gift', {
      is: true,
      then: (schema) => schema.integer().nullable(true).positive().max(validationConfig.number_max),
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
  const { field: requestedDurationControl } = useController({
    name: 'requested_duration',
    control,
    defaultValue: state.formData.requested_duration,
  });
  const wantsDirectDebitControl = useController({
    name: 'wants_direct_debit',
    control,
    defaultValue: state.formData.wants_direct_debit,
  });
  const isAnonymousControl = useController({
    name: 'is_anonymous',
    control,
    defaultValue: state.formData.is_anonymous,
  });

  const defaultAmountIsCustom = !AMOUNT_OPTIONS.some((o) => o.value === amountControl.value);
  const [isCustomAmount, setIsCustomAmount] = useState(defaultAmountIsCustom);

  const defaultRequestedDurationIsCustom = !REQUESTED_DURATION_OPTIONS.some(
    (o) => o.value === requestedDurationControl.value
  );
  const [isCustomRequestedDuration, setIsCustomRequestedDuration] = useState(
    defaultRequestedDurationIsCustom
  );

  const onSubmit = (data: SponsorshipParamsStepFields) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="p-5 border-b border-gray-light">
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
        <div className="mb-form-group-hint">
          Nulla quis lorem ut libero malesuada feugiat. Vivamus magna justo, lacinia eget
          consectetur sed, convallis at tellus.
        </div>
      </div>

      <div className="p-5 border-b border-gray-light">
        <div className="mb-form-group-label">Mesečni znesek</div>
        <div className="grid grid-cols-2 items-start gap-4 lg:grid-cols-3">
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
          <div className="col-span-2">
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
        <div className="mb-form-group-hint">
          Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.
        </div>
      </div>

      {isGiftControl.value === true && (
        <div className="p-5 border-b border-gray-light">
          <div className="mb-form-group-label">Trajanje</div>
          <div className="grid grid-cols-2 items-start gap-4 lg:grid-cols-3">
            {REQUESTED_DURATION_OPTIONS.map((option) => (
              <BoxOption
                key={option.key}
                label={option.label}
                onClick={() => {
                  setIsCustomRequestedDuration(false);
                  requestedDurationControl.onChange(option.value);
                }}
                isSelected={
                  !isCustomRequestedDuration && option.value === requestedDurationControl.value
                }
              />
            ))}
            <div className="col-span-2">
              <Input
                value={
                  isCustomRequestedDuration && requestedDurationControl.value !== null
                    ? requestedDurationControl.value
                    : ''
                }
                ref={requestedDurationControl.ref}
                isInvalid={!!errors.requested_duration}
                placeholder="Poljubno število mesecev"
                onChange={(event) => {
                  setIsCustomRequestedDuration(true);
                  requestedDurationControl.onChange(event);
                }}
              />
              {errors.requested_duration && <Error>{errors.requested_duration.message}</Error>}
            </div>
          </div>
          <div className="mb-form-group-hint">
            Proin eget tortor risus. Curabitur non nulla sit amet nisl tempus convallis quis ac
            lectus.
          </div>
        </div>
      )}

      <div className="p-5">
        <div className="mb-form-group">
          <HookFormCheckbox label="Želim plačati prek trajnika" control={wantsDirectDebitControl} />
          <div className="mb-form-group-hint">
            Quisque velit nisi, pretium ut lacinia in, elementum id enim. Vestibulum ac diam sit
            amet quam vehicula elementum sed sit amet dui.
          </div>
        </div>

        <div className="mb-form-group">
          <HookFormCheckbox label="Botrstvo naj bo anonimno" control={isAnonymousControl} />
          <div className="mb-form-group-hint">
            Curabitur non nulla sit amet nisl tempus convallis quis ac lectus. Vestibulum ac diam
            sit amet quam vehicula elementum sed sit amet dui.
          </div>
        </div>

        <ButtonRow>
          <SubmitButton>Naprej</SubmitButton>
        </ButtonRow>
      </div>
    </form>
  );
};
