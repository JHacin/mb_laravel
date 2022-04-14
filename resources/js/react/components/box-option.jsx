import clsx from 'clsx';
import React from 'react';

export function BoxOption({ onClick, isSelected, children }) {
  return (
    <button
      type="button"
      className={clsx('border-2 p-3 cursor-pointer', isSelected && 'border-primary')}
      onClick={onClick}
    >
      {children}
    </button>
  );
}
