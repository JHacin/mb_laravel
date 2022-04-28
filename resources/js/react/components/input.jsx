import React from 'react';
import clsx from 'clsx';

function InputComponent(
  { isInvalid = false, placeholder = '', onChange, value, autoComplete },
  ref
) {
  return (
    <input
      ref={ref}
      type="text"
      className={clsx('mb-input', isInvalid && 'mb-input--invalid')}
      placeholder={placeholder}
      onChange={onChange}
      value={value}
      autoComplete={autoComplete}
    />
  );
}

export const Input = React.forwardRef(InputComponent);
