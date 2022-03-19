import ReactDOM from 'react-dom';
import React from 'react';
import { CatSponsorForm } from './cat-sponsor-form/index';

const root = document.getElementById('react-root__cat-sponsor-form');

if (root) {
  const props = JSON.parse(root.getAttribute('data-props'));

  ReactDOM.render(
    <CatSponsorForm props={props} />,
    document.getElementById('react-root__cat-sponsor-form')
  );
}
