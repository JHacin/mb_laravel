import React, { ChangeEventHandler } from 'react';
import { SelectOption } from 'react/types';

interface SelectProps {
  options: SelectOption[];
  value: string | number | boolean;
  onChange: ChangeEventHandler;
}

export const Select = React.forwardRef<HTMLSelectElement, SelectProps>(
  ({ options, value, onChange }, ref) => {
    return (
      <select value={value as any} onChange={onChange} className="mb-select" ref={ref}>
        {options.map((option) => (
          <option value={option.value as any} key={option.key}>
            {option.label}
          </option>
        ))}
      </select>
    );
  }
);
