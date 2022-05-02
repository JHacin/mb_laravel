import clsx from 'clsx';
import React, { FC, MouseEventHandler } from 'react';

interface BoxOptionProps {
  onClick: MouseEventHandler
  isSelected: boolean
  label: string
}

export const BoxOption: FC<BoxOptionProps> = ({ onClick, isSelected, label }) => {
  return (
    <button
      type="button"
      className={clsx(
        'font-semibold py-2 px-4 border select-none transition-all',
        !isSelected &&
          'cursor-pointer border-gray-light shadow shadow-gray-light hover:shadow-gray-semi',
        isSelected &&
          'bg-secondary border-transparent text-white cursor-default pointer-events-none'
      )}
      onClick={onClick}
    >
      {label}
    </button>
  );
}
