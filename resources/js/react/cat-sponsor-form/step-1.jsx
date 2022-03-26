import React from 'react';
import { useForm } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import { updateAction } from './updateAction';

export function Step1({ onNext }) {
  const { actions, state } = useStateMachine({ updateAction });
  const { register, handleSubmit } = useForm({
    defaultValues: state.data,
  });

  const onSubmit = (data) => {
    actions.updateAction(data);
    onNext();
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Komu je botrstvo namenjeno?</div>
        <div className="flex space-x-4">
          <label htmlFor="is_gift_no" className="mb-inline-selectable-label">
            <input
              {...register('is_gift')}
              type="radio"
              name="is_gift"
              value="no"
              id="is_gift_no"
            />
            <span>Boter bom jaz</span>
          </label>
          <label htmlFor="is_gift_yes" className="mb-inline-selectable-label">
            <input
              {...register('is_gift')}
              type="radio"
              name="is_gift"
              value="yes"
              id="is_gift_yes"
            />
            <span>Botrstvo želim podariti</span>
          </label>
        </div>
      </div>

      <div className="mb-form-group">TODO Znesek</div>
      <div className="mb-form-group">TODO Trajanje (če je gift)</div>

      <div className="mb-form-group">
        <label htmlFor="wants_direct_debit" className="mb-inline-selectable-label">
          <input {...register('wants_direct_debit')} type="checkbox" id="wants_direct_debit" />
          <span>Želim, da mi pošljete informacije v zvezi z ureditvijo trajnika</span>
        </label>
      </div>

      <div className="mb-form-group">
        <label htmlFor="is_anonymous" className="mb-inline-selectable-label">
          <input {...register('is_anonymous')} type="checkbox" id="is_anonymous" />
          <span>Botrstvo naj bo anonimno</span>
        </label>
      </div>

      <button type="submit" className="mb-btn mb-btn-primary">
        Naprej
      </button>
    </form>
  );
}
