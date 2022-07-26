import React, { FC } from 'react';
import { UseControllerReturn } from 'react-hook-form';
import { Error } from './error';
import { Select } from './select';
import { SelectOption } from '../types';

interface HookFormSelectProps {
  control: UseControllerReturn<any, any>;
  options: SelectOption[];
}

export const HookFormSelect: FC<HookFormSelectProps> = ({
  control: { field, fieldState },
  options,
}) => (
  <>
    <Select options={options} value={field.value} onChange={field.onChange} ref={field.ref} />
    {fieldState.error && <Error>{fieldState.error.message}</Error>}
  </>
);
