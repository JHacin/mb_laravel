import React from 'react';
import { useForm } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import { updateFormDataAction } from './updateFormDataAction';

export function Step2({ onPrev, onNext, countryList }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });
  const {
    register,
    handleSubmit,
    formState: { errors },
  } = useForm({
    defaultValues: state.data,
  });

  const onSubmit = (data) => {
    actions.updateFormDataAction(data);
    onNext();
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="my-3 border">
        <label htmlFor="payer_email">
          Email
          <input
            {...register('payer_email', { required: true })}
            className="mb-input"
            id="payer_email"
          />
        </label>

        {errors.payer_email && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="payer_first_name">
          Ime
          <input
            {...register('payer_first_name', { required: true })}
            className="mb-input"
            id="payer_first_name"
          />
        </label>

        {errors.payer_first_name && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="payer_last_name">
          Priimek
          <input
            {...register('payer_last_name', { required: true })}
            className="mb-input"
            id="payer_last_name"
          />
        </label>

        {errors.payer_last_name && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <div>Spol</div>
        <label htmlFor="payer_gender_female">
          <input
            {...register('payer_gender')}
            type="radio"
            name="payer_gender"
            value="female"
            id="payer_gender_female"
          />
          Ženska
        </label>
        <label htmlFor="payer_gender_male">
          <input
            {...register('payer_gender')}
            type="radio"
            name="payer_gender"
            value="male"
            id="payer_gender_male"
          />
          Moški
        </label>
      </div>

      <div className="my-3 border">
        <label htmlFor="payer_address">
          Ulica in hišna številka
          <input
            {...register('payer_address', { required: true })}
            className="mb-input"
            id="payer_address"
          />
        </label>

        {errors.payer_address && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="payer_zip_code">
          Poštna št.
          <input
            {...register('payer_zip_code', { required: true })}
            className="mb-input"
            id="payer_zip_code"
          />
        </label>

        {errors.payer_zip_code && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="payer_city">
          Kraj
          <input
            {...register('payer_city', { required: true })}
            className="mb-input"
            id="payer_city"
          />
        </label>

        {errors.payer_city && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="payer_country">
          Država
          <select {...register('payer_country')} className="mb-select" id="payer_country">
            {Object.keys(countryList.options).map((countryCode) => (
              <option value={countryCode} key={countryCode}>
                {countryList.options[countryCode]}
              </option>
            ))}
          </select>
        </label>
      </div>

      <div>
        <strong>(?) STEP 3 - Podatki obdarovanca</strong>
      </div>

      <div className="my-3 border">
        <label htmlFor="giftee_email">
          Email
          <input
            {...register('giftee_email', { required: true })}
            className="mb-input"
            id="giftee_email"
          />
        </label>

        {errors.giftee_email && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="giftee_first_name">
          Ime
          <input
            {...register('giftee_first_name', { required: true })}
            className="mb-input"
            id="giftee_first_name"
          />
        </label>

        {errors.giftee_first_name && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="giftee_last_name">
          Priimek
          <input
            {...register('giftee_last_name', { required: true })}
            className="mb-input"
            id="giftee_last_name"
          />
        </label>

        {errors.giftee_last_name && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <div>Spol</div>
        <label htmlFor="giftee_gender_female">
          <input
            {...register('giftee_gender')}
            type="radio"
            name="giftee_gender"
            value="female"
            id="giftee_gender_female"
          />
          Ženska
        </label>
        <label htmlFor="giftee_gender_male">
          <input
            {...register('giftee_gender')}
            type="radio"
            name="giftee_gender"
            value="male"
            id="giftee_gender_male"
          />
          Moški
        </label>
      </div>

      <div className="my-3 border">
        <label htmlFor="giftee_address">
          Ulica in hišna številka
          <input
            {...register('giftee_address', { required: true })}
            className="mb-input"
            id="giftee_address"
          />
        </label>

        {errors.giftee_address && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="giftee_zip_code">
          Poštna št.
          <input
            {...register('giftee_zip_code', { required: true })}
            className="mb-input"
            id="giftee_zip_code"
          />
        </label>

        {errors.giftee_zip_code && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="giftee_city">
          Kraj
          <input
            {...register('giftee_city', { required: true })}
            className="mb-input"
            id="giftee_city"
          />
        </label>

        {errors.giftee_city && <div style={{ color: 'red' }}>Error</div>}
      </div>

      <div className="my-3 border">
        <label htmlFor="giftee_country">
          Država
          <select {...register('giftee_country')} className="mb-select" id="giftee_country">
            {Object.keys(countryList.options).map((countryCode) => (
              <option value={countryCode} key={countryCode}>
                {countryList.options[countryCode]}
              </option>
            ))}
          </select>
        </label>
      </div>

      <button type="button" className="mb-btn mb-btn-secondary" onClick={onPrev}>
        Nazaj
      </button>

      <button type="submit" className="mb-btn mb-btn-primary">
        Naprej
      </button>
    </form>
  );
}
