import React, { FC, ReactNode } from 'react';

interface ErrorProps {
  children: ReactNode;
}

export const Error: FC<ErrorProps> = ({ children }) => (
  <div className="mb-form-error">{children}</div>
);
