import React, { ChangeEventHandler, FocusEventHandler } from 'react';
import clsx from 'clsx';

interface InputProps {
  isInvalid: boolean
  placeholder?: string
  onChange: ChangeEventHandler
  onBlur?: FocusEventHandler
  value: string | number
  name?: string
  autoComplete?: string
}

export const Input = React.forwardRef<HTMLInputElement, InputProps>(
  ({ isInvalid = false, placeholder = '', onChange, onBlur, value, name = '', autoComplete }, ref) => {
    return (
      <input
        ref={ref}
        name={name}
        type="text"
        className={clsx('mb-input', isInvalid && 'mb-input--invalid')}
        placeholder={placeholder}
        onChange={onChange}
        onBlur={onBlur}
        value={value}
        autoComplete={autoComplete}
      />
    );
  }
);
