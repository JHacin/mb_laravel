import ReactDOM from 'react-dom';
import React from 'react';
import { createStore, StateMachineProvider } from 'little-state-machine';
import { CatSponsorForm } from './cat-sponsor-form/index';

const root = document.getElementById('react-root__cat-sponsor-form');

if (root) {
  const serverSideProps = JSON.parse(root.getAttribute('data-props'));

  createStore(
    {
      formData: {
        is_gift: false,
        wants_direct_debit: false,
        is_anonymous: false,
        monthly_amount: 5,
        duration: 12,
        payer_email: '',
        payer_first_name: '',
        payer_last_name: '',
        payer_gender: Number(serverSideProps.gender.default),
        payer_address: '',
        payer_zip_code: '',
        payer_city: '',
        payer_country: 'SI',
        giftee_email: '',
        giftee_first_name: '',
        giftee_last_name: '',
        giftee_gender: Number(serverSideProps.gender.default),
        giftee_address: '',
        giftee_zip_code: '',
        giftee_city: '',
        giftee_country: 'SI',
        is_agreed_to_terms: false,
      },
      formState: {
        isSubmitting: false,
      },
    },
    {
      persist: 'none',
    }
  );

  ReactDOM.render(
    <StateMachineProvider>
      <CatSponsorForm serverSideProps={serverSideProps} />
    </StateMachineProvider>,
    document.getElementById('react-root__cat-sponsor-form')
  );
}
