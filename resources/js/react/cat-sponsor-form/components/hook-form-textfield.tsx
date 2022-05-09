import React, { FC } from 'react';
import { UseControllerReturn } from 'react-hook-form';
import { Error } from '../../components/error';
import { Input } from '../../components/input';

interface HookFormTextFieldProps {
  control: UseControllerReturn<any, any>;
  autoComplete: string;
}

export const HookFormTextField: FC<HookFormTextFieldProps> = ({
  control: { field, fieldState },
  autoComplete,
}) => (
  <>
    <Input
      onChange={field.onChange}
      onBlur={field.onBlur}
      isInvalid={!!fieldState.error}
      value={field.value}
      ref={field.ref}
      autoComplete={autoComplete}
    />
    {fieldState.error && <Error>{fieldState.error.message}</Error>}
  </>
);
