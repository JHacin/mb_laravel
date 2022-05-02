import clsx from 'clsx';
import React from 'react';

export function Button({
  type = 'button',
  color,
  size,
  onClick,
  isLoading,
  isDisabled,
  startIcon,
  classes = '',
  children,
}) {
  return (
    <button
      type={type}
      disabled={isDisabled}
      className={clsx(
        'mb-btn',
        !isDisabled && `mb-btn-${color}`,
        isDisabled && 'mb-btn-disabled',
        size && `mb-btn-${size}`,
        classes && classes
      )}
      onClick={onClick}
    >
      {startIcon && <span>{startIcon}</span>}

      {isLoading && (
        <span>
          <i className="fas fa-circle-notch fa-spin" />
        </span>
      )}

      {children && <span>{children}</span>}
    </button>
  );
}
