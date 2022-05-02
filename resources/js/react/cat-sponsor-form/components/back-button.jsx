import React from 'react';
import { Button } from '../../components/button';

export function BackButton({ onClick }) {
  return (
    <Button
      type="button"
      color="primary-inverted"
      size="lg"
      onClick={onClick}
      startIcon={<i className="fa-solid fa-caret-left" />}
      classes="pl-0 space-x-3"
    >
      Nazaj
    </Button>
  );
}
