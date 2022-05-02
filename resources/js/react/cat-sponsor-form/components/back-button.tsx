import React, { FC, MouseEventHandler } from 'react';
import { Button } from '../../components/button';

interface BackButtonProps {
  onClick: MouseEventHandler
}

export const BackButton: FC<BackButtonProps> = ({ onClick }) => {
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
