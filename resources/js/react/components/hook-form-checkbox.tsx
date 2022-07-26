import React, { FC } from 'react';
import { UseControllerReturn } from 'react-hook-form';
import { Checkbox } from './checkbox';
import { Error } from './error';

interface HookFormCheckboxProps {
  control: UseControllerReturn<any, any>;
  label: string;
}

export const HookFormCheckbox: FC<HookFormCheckboxProps> = ({
  control: { field, fieldState },
  label,
}) => (
  <>
    <Checkbox
      label={label}
      id={field.name}
      onChange={field.onChange}
      value={field.value}
      ref={field.ref}
    />
    {fieldState.error && <Error>{fieldState.error.message}</Error>}
  </>
);
