import React from 'react';
import clsx from 'clsx';

function InputComponent({ isInvalid = false, placeholder = '', onChange }, ref) {
  return (
    <input
      ref={ref}
      type="text"
      className={clsx('mb-input', isInvalid && 'mb-input--invalid')}
      placeholder={placeholder}
      onChange={onChange}
    />
  );
}

export const Input = React.forwardRef(InputComponent);
