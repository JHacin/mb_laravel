import React from 'react';
import clsx from 'clsx';

function InputComponent({ isInvalid = false, placeholder = '', onChange, value }, ref) {
  return (
    <input
      ref={ref}
      type="text"
      className={clsx('mb-input', isInvalid && 'mb-input--invalid')}
      placeholder={placeholder}
      onChange={onChange}
      value={value}
    />
  );
}

export const Input = React.forwardRef(InputComponent);
