import React, { ChangeEventHandler, FC } from 'react';
import { UseControllerReturn } from 'react-hook-form';
import { Error } from './error';
import { Select } from './select';
import { SelectOption } from '../types';

interface HookFormSelectProps {
  control: UseControllerReturn<any, any>;
  options: SelectOption[];
  onChange?: (value: string) => void;
}

export const HookFormSelect: FC<HookFormSelectProps> = ({
  control: { field, fieldState },
  options,
  onChange,
}) => {
  const handleOnChange: ChangeEventHandler<HTMLSelectElement> = (event) => {
    field.onChange(event);
    onChange?.(event.target.value);
  };

  return (
    <>
      <Select options={options} value={field.value} onChange={handleOnChange} ref={field.ref} />
      {fieldState.error && <Error>{fieldState.error.message}</Error>}
    </>
  );
};
