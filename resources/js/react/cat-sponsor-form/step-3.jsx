import React from 'react';
import { useFormContext } from 'react-hook-form';

export function Step3({ onPrev }) {
  const { register } = useFormContext();

  return (
    <div>
      <div>Povzetek</div>

      <div className="my-3 border">
        <label htmlFor="is_agreed_to_terms">
          Strinjam se
          <input {...register('is_agreed_to_terms')} type="checkbox" id="is_agreed_to_terms" />
        </label>
      </div>

      <button type="button" className="mb-btn mb-btn-secondary" onClick={onPrev}>
        Nazaj
      </button>

      <button type="submit" className="mb-btn mb-btn-primary">
        Potrdi
      </button>
    </div>
  );
}
