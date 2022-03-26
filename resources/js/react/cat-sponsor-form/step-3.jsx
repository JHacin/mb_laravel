import React from 'react';
import { useForm } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import { updateAction } from './updateAction';

export function Step3({ onPrev }) {
  const { actions, state } = useStateMachine({ updateAction });

  const { register, handleSubmit } = useForm({
    defaultValues: state.data,
  });

  const onSubmit = (data) => {
    actions.updateAction(data);
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
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
    </form>
  );
}
