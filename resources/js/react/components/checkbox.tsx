import React, { ChangeEventHandler, forwardRef } from 'react';

interface CheckboxProps {
  id: string;
  onChange: ChangeEventHandler<HTMLInputElement>;
  label: string;
  value: boolean;
}

export const Checkbox = forwardRef<HTMLInputElement, CheckboxProps>(
  ({ id, onChange, label, value }, ref) => (
    <label htmlFor={id} className="mb-inline-selectable-label">
      <input ref={ref} type="checkbox" id={id} onChange={onChange} checked={value} />
      <span>{label}</span>
    </label>
  )
);
