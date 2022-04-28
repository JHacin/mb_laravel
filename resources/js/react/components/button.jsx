import React from 'react';

export function Button({ type = 'button', color, onClick, children }) {
  return (
    <button type={type} className={`mb-btn mb-btn-${color}`} onClick={onClick}>
      {children}
    </button>
  );
}
