import clsx from 'clsx';
import React from 'react';

export function BoxOption({ onClick, isSelected, label }) {
  return (
    <button
      type="button"
      className={clsx(
        'font-semibold py-2 px-4 border select-none transition-all',
        !isSelected &&
          'cursor-pointer border-gray-light shadow shadow-gray-light hover:shadow-gray-semi',
        isSelected && 'bg-secondary border-transparent text-white pointer-events-none'
      )}
      onClick={onClick}
    >
      {label}
    </button>
  );
}
