import React, { FC } from 'react';
import { useForm, useController } from 'react-hook-form';
import * as yup from 'yup';
import { yupResolver } from '@hookform/resolvers/yup';
import { BoxOption } from '../../components/box-option';
import { Input } from '../../components/input';
import { Error } from '../../components/error';
import { SharedStepProps, SpecialSponsorshipParamsStepFields } from '../types';
import { ButtonRow } from '../../components/button-row';
import { HookFormCheckbox } from '../../components/hook-form-checkbox';
import { SubmitButton } from '../../components/submit-button';
import { HookFormSelect } from '../../components/hook-form-select';
import { useSpecialSponsorshipFormStore } from '../store';
import { YupValidationSchemaShape } from '../../sponsorship-forms/types';
import { FORM_MODE, IS_GIFT_OPTIONS } from '../../sponsorship-forms/constants';
import { useStoreValuesSync } from '../../sponsorship-forms/store/use-store-values-sync';

export const SponsorshipParamsStep: FC<SharedStepProps> = ({
  onNext,
  validationConfig,
  typeOptions,
  typeAmounts,
}) => {
  const { values, updateValues } = useSpecialSponsorshipFormStore();

  const validationSchema = yup.object<YupValidationSchemaShape<SpecialSponsorshipParamsStepFields>>(
    {
      is_gift: yup.boolean(),
      donation_amount: yup.lazy((_value, options) => {
        const parent: SpecialSponsorshipParamsStepFields = options.parent;
        return yup
          .number()
          .integer()
          .min(typeAmounts[parent.type])
          .max(validationConfig.integer_max)
          .required();
      }),
      type: yup.number(),
      is_anonymous: yup.boolean(),
    }
  );

  const {
    handleSubmit,
    control,
    watch,
    formState: { errors },
  } = useForm<SpecialSponsorshipParamsStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useStoreValuesSync<SpecialSponsorshipParamsStepFields>({ watch, callback: updateValues });

  const typeControl = useController({
    name: 'type',
    control,
    defaultValue: values.type,
  });

  const { field: isGiftControl } = useController({
    name: 'is_gift',
    control,
    defaultValue: values.is_gift,
  });
  const { field: amountControl } = useController({
    name: 'donation_amount',
    control,
    defaultValue: values.donation_amount,
  });
  const isAnonymousControl = useController({
    name: 'is_anonymous',
    control,
    defaultValue: values.is_anonymous,
  });

  const handleTypeChange = (type: string) => {
    const newMinAmount = typeAmounts[type];
    amountControl.onChange(newMinAmount);
  };

  const onSubmit = (data: SpecialSponsorshipParamsStepFields) => {
    updateValues(data);
    onNext();
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="p-5 border-b border-gray-light">
        <div className="mb-form-group-label">Tip botrstva</div>
        <HookFormSelect options={typeOptions} control={typeControl} onChange={handleTypeChange} />
        <div className="mb-form-group-hint">
          Nulla quis lorem ut libero malesuada feugiat. Vivamus magna justo, lacinia eget
          consectetur sed, convallis at tellus.
        </div>
      </div>
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
        <div className="mb-form-group-label">Znesek</div>
        <div className="grid grid-cols-2 items-start gap-4 lg:grid-cols-3">
          <div className="col-span-2">
            <Input
              ref={amountControl.ref}
              value={amountControl.value}
              isInvalid={!!errors.donation_amount}
              placeholder="Poljubni znesek v evrih"
              onChange={(event) => {
                amountControl.onChange(event);
              }}
            />
            {errors.donation_amount && <Error>{errors.donation_amount.message}</Error>}
          </div>
        </div>
        <div className="mb-form-group-hint">
          Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae.
        </div>
      </div>

      <div className="p-5">
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