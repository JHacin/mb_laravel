import React, { FC, ReactNode } from 'react';

interface ButtonRowProps {
  children: ReactNode;
}

export const ButtonRow: FC<ButtonRowProps> = ({ children }) => (
  <div className="flex justify-between items-center mt-7 lg:mt-8">{children}</div>
);
