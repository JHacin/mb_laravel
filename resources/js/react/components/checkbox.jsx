import React from 'react';

export function Checkbox({ id, onChange, label }) {
  return (
    <label htmlFor={id} className="mb-inline-selectable-label">
      <input type="checkbox" id={id} onChange={onChange} />
      <span>{label}</span>
    </label>
  );
}
