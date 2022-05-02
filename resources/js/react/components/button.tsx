import clsx from 'clsx';
import React, { FC, MouseEventHandler, ReactNode } from 'react';

interface ButtonProps {
  type: 'button' | 'submit'
  color: 'primary' | 'secondary' | 'primary-inverted'
  size: 'lg'
  onClick?: MouseEventHandler
  isLoading?: boolean
  isDisabled?: boolean
  startIcon: ReactNode
  classes?: string
  children: ReactNode
}

export const Button: FC<ButtonProps> = ({
  type = 'button',
  color,
  size,
  onClick,
  isLoading = false,
  isDisabled = false,
  startIcon,
  classes = '',
  children,
}) => {
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
