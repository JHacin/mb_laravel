import React, { ChangeEventHandler, FC, forwardRef } from 'react';

interface CheckboxProps {
  id: string
  onChange: ChangeEventHandler<HTMLInputElement>
  label: string
  value: boolean
}

export const Checkbox = forwardRef<HTMLInputElement, CheckboxProps>(({ id, onChange, label, value }, ref) => {
  return (
    <label htmlFor={id} className="mb-inline-selectable-label">
      <input ref={ref} type="checkbox" id={id} onChange={onChange} checked={value} />
      <span>{label}</span>
    </label>
  );
});
