import React from 'react';
import { Error } from '../../components/error';
import { Input } from '../../components/input';

function SimpleTextFieldComponent({ control: { field, fieldState }, autoComplete }, ref) {
  return (
    <>
      <Input
        onChange={field.onChange}
        hasError={!!fieldState.error}
        value={field.value}
        ref={ref}
        autoComplete={autoComplete}
      />
      {fieldState.error && <Error>{fieldState.error.message}</Error>}
    </>
  );
}

export const SimpleTextField = React.forwardRef(SimpleTextFieldComponent);
