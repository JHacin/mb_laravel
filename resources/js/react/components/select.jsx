import React from 'react';

export function Select({ options, selectedValue, onChange }) {
  return (
    <select value={selectedValue} onChange={onChange} className="mb-select">
      {options.map((option) => (
        <option value={option.value} key={option.key}>
          {option.label}
        </option>
      ))}
    </select>
  );
}
