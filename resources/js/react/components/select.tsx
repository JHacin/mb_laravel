import React, { ChangeEventHandler } from 'react';
import { SelectOption } from '../types';

interface SelectProps {
  options: SelectOption[];
  value: string | number;
  onChange: ChangeEventHandler;
}

export const Select = React.forwardRef<HTMLSelectElement, SelectProps>(
  ({ options, value, onChange }, ref) => (
    <select value={value} onChange={onChange} className="mb-select" ref={ref}>
      {options.map((option) => (
        <option value={option.value} key={option.key}>
          {option.label}
        </option>
      ))}
    </select>
  )
);
