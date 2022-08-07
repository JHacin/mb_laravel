import * as yup from 'yup';
import { locale } from '../../config/yup-locale';
import ReactDOM from 'react-dom';
import React, { FC } from 'react';
import { SponsorshipFormStoreContext } from '../store';
import { StoreApi } from 'zustand';
import { FormStore } from '../types';

interface GetServerSidePropsParams {
  rootId: string;
}

interface RenderRootParams<TServerSideProps, TValues, TAnyStepFields> {
  rootId: string;
  EntryComponent: FC<{ serverSideProps: TServerSideProps }>;
  serverSideProps: TServerSideProps;
  storeContextValue: StoreApi<FormStore<TValues, TAnyStepFields>>;
}

const getRootElement = (id: string) => {
  const root = document.getElementById(id);

  if (!root) {
    throw new Error('React root node missing.');
  }

  return root;
};

export const getServerSideProps = <TServerSideProps,>({ rootId }: GetServerSidePropsParams) => {
  const root = getRootElement(rootId);

  const serverSideProps: TServerSideProps = JSON.parse(root.getAttribute('data-props') as string);

  return serverSideProps;
};

export const renderRoot = <TServerSideProps, TValues, TAnyStepFields>({
  rootId,
  EntryComponent,
  serverSideProps,
  storeContextValue,
}: RenderRootParams<TServerSideProps, TValues, TAnyStepFields>) => {
  const root = getRootElement(rootId);

  yup.setLocale(locale);

  ReactDOM.render(
    <React.StrictMode>
      <SponsorshipFormStoreContext.Provider value={storeContextValue}>
        <EntryComponent serverSideProps={serverSideProps} />
      </SponsorshipFormStoreContext.Provider>
    </React.StrictMode>,
    root
  );
};
