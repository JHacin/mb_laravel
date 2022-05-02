import React from 'react';
import clsx from 'clsx';

function InputComponent(
  { isInvalid = false, placeholder = '', onChange, onBlur, value, name, autoComplete },
  ref
) {
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

export const Input = React.forwardRef(InputComponent);
