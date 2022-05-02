import React from 'react';
import { Button } from '../../components/button';

export function SubmitButton({ isLoading, isDisabled, startIcon, children }) {
  return (
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
}
