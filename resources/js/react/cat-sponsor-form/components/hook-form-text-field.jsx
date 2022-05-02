import React from 'react';
import { Error } from '../../components/error';
import { Input } from '../../components/input';

export function HookFormTextField({ control: { field, fieldState }, autoComplete }) {
  return (
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
}
