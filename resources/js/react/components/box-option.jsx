import clsx from 'clsx';
import React from 'react';

export function BoxOption({ onClick, isSelected, children }) {
  return (
    <button
      type="button"
      className={clsx(
        'font-semibold py-2 px-4 cursor-pointer shadow shadow-gray-light border border-gray-light select-none hover:shadow-gray-semi',
        isSelected &&
          'bg-secondary border-transparent shadow-transparent text-white pointer-events-none'
      )}
      onClick={onClick}
    >
      {children}
    </button>
  );
}
