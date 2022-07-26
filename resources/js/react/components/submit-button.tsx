import React, { FC, ReactNode } from 'react';
import { Button } from './button';

interface SubmitButtonProps {
  isLoading?: boolean;
  isDisabled?: boolean;
  startIcon?: ReactNode;
  children: ReactNode;
}

export const SubmitButton: FC<SubmitButtonProps> = ({
  isLoading = false,
  isDisabled = false,
  startIcon,
  children,
}) => (
  <Button
    type="submit"
    color="primary"
    size="lg"
    isLoading={isLoading}
    startIcon={startIcon}
    isDisabled={isDisabled || isLoading}
  >
    {children}
  </Button>
);
