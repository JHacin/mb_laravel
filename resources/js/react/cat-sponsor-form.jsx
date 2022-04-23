import ReactDOM from 'react-dom';
import React from 'react';
import { createStore, StateMachineProvider } from "little-state-machine";
import { CatSponsorForm } from './cat-sponsor-form/index';
import { initialValues } from './cat-sponsor-form/model';

const root = document.getElementById('react-root__cat-sponsor-form');

if (root) {
  const props = JSON.parse(root.getAttribute('data-props'));

  createStore({
    formData: initialValues,
  });

  ReactDOM.render(
    <StateMachineProvider>
      <CatSponsorForm props={props} />
    </StateMachineProvider>,
    document.getElementById('react-root__cat-sponsor-form')
  );
}
