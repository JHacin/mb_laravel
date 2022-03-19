import React from 'react';
import { useFormContext } from 'react-hook-form';

export function Step1({ onNext }) {
  const { register } = useFormContext();

  const handleNextClick = () => {
    onNext();
  };

  return (
    <div>
      <div className="my-3 border">
        <div>Tip (zame/darilo)</div>
        <label htmlFor="is_gift_yes">
          <input
            {...register('is_gift')}
            type="radio"
            name="is_gift"
            value="yes"
            id="is_gift_yes"
          />
          Darilo
        </label>
        <label htmlFor="is_gift_no">
          <input {...register('is_gift')} type="radio" name="is_gift" value="no" id="is_gift_no" />
          Zame
        </label>
      </div>

      <div>Znesek</div>

      <div className="my-3 border">
        <label htmlFor="wants_direct_debit">
          Trajnik
          <input {...register('wants_direct_debit')} type="checkbox" id="wants_direct_debit" />
        </label>
      </div>

      <div>Trajanje (če je gift)</div>

      <div className="my-3 border">
        <label htmlFor="is_anonymous">
          Anonimno
          <input {...register('is_anonymous')} type="checkbox" id="is_anonymous" />
        </label>
      </div>

      <button type="button" className="mb-btn mb-btn-primary" onClick={handleNextClick}>
        Naprej
      </button>
    </div>
  );
}
