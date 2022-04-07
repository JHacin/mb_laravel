import React from 'react';
import { useForm, useController } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import { updateAction } from './updateAction';

export function Step1({ onNext }) {
  const { actions, state } = useStateMachine({ updateAction });
  const { register, handleSubmit, control, watch } = useForm({
    defaultValues: state.data,
  });
  const { field: monthlyAmountControl } = useController({ name: 'monthly_amount', control });
  const { field: durationControl } = useController({ name: 'duration', control });

  const onSubmit = (data) => {
    actions.updateAction(data);
    onNext();
  };

  React.useEffect(() => {
    const subscription = watch((value) => console.log(JSON.stringify(value, null, '\t')));
    return () => subscription.unsubscribe();
  }, [watch]);

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

      <div className="mb-form-group">
        <div className="mb-form-group-label">Mesečni znesek</div>
        <div className="flex">
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => monthlyAmountControl.onChange(5)}
          >
            5€
          </button>
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => monthlyAmountControl.onChange(10)}
          >
            10€
          </button>
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => monthlyAmountControl.onChange(20)}
          >
            20€
          </button>
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => monthlyAmountControl.onChange(50)}
          >
            50€
          </button>
          <input
            type="number"
            onChange={(ev) => monthlyAmountControl.onChange(Number(ev.target.value))}
          />
        </div>
      </div>
      <div className="mb-form-group">
        <div className="mb-form-group-label">Trajanje (če je gift)</div>
        <div className="flex">
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => durationControl.onChange(1)}
          >
            1 mesec
          </button>
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => durationControl.onChange(3)}
          >
            3 mesece
          </button>
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => durationControl.onChange(6)}
          >
            6 mesecev
          </button>
          <button
            type="button"
            className="border p-3 cursor-pointer"
            onClick={() => durationControl.onChange(12)}
          >
            1 leto
          </button>
          <input
            type="number"
            onChange={(ev) => durationControl.onChange(Number(ev.target.value))}
          />
        </div>
      </div>

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
