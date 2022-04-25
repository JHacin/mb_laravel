import React from 'react';

function SelectComponent({ options, value, onChange }, ref) {
  return (
    <select value={value} onChange={onChange} className="mb-select" ref={ref}>
      {options.map((option) => (
        <option value={option.value} key={option.key}>
          {option.label}
        </option>
      ))}
    </select>
  );
}

export const Select = React.forwardRef(SelectComponent);
