import React from 'react';

function CheckboxComponent({ id, onChange, label, value }, ref) {
  return (
    <label htmlFor={id} className="mb-inline-selectable-label">
      <input ref={ref} type="checkbox" id={id} onChange={onChange} checked={value} />
      <span>{label}</span>
    </label>
  );
}

export const Checkbox = React.forwardRef(CheckboxComponent);
