import { ServerSideProps, SpecialSponsorshipFormState } from './types';
import * as yup from 'yup';
import { locale } from '../config/yup-locale';
import { createStore, StateMachineProvider } from 'little-state-machine';
import ReactDOM from 'react-dom';
import React from 'react';
import { SpecialSponsorshipForm } from './special-sponsorship-form';

const root = document.getElementById('react-root__special-sponsorship-form');

if (root) {
  const serverSideProps: ServerSideProps = JSON.parse(root.getAttribute('data-props') as string);

  yup.setLocale(locale);

  const initialState: SpecialSponsorshipFormState = {
    formData: {
      type: 0, // todo from selected type
      is_gift: false,
      is_anonymous: false,
      donation_amount: 5, // todo from selected type
      payer_email: '',
      payer_first_name: '',
      payer_last_name: '',
      payer_gender: Number(serverSideProps.gender.default),
      payer_address: '',
      payer_zip_code: '',
      payer_city: '',
      payer_country: serverSideProps.countryList.default,
      giftee_email: '',
      giftee_first_name: '',
      giftee_last_name: '',
      giftee_gender: Number(serverSideProps.gender.default),
      giftee_address: '',
      giftee_zip_code: '',
      giftee_city: '',
      giftee_country: serverSideProps.countryList.default,
      is_agreed_to_terms: false,
    },
    formState: {
      isSubmitting: false,
      isSubmitSuccess: false,
      isSubmitError: false,
    },
  };

  createStore(initialState, {
    name: 'special-sponsorship-form',
    persist: 'none',
  });

  ReactDOM.render(
    <React.StrictMode>
      <StateMachineProvider>
        <SpecialSponsorshipForm serverSideProps={serverSideProps} />
      </StateMachineProvider>
    </React.StrictMode>,
    root
  );
}
