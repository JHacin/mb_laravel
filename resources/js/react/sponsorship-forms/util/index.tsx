import * as yup from 'yup';
import { locale } from '../../config/yup-locale';
import ReactDOM from 'react-dom';
import React, { FC } from 'react';

interface RenderRootParams<TServerSideProps> {
  rootId: string;
  EntryComponent: FC<{ serverSideProps: TServerSideProps }>;
}

export const renderRoot = <TServerSideProps,>({
  rootId,
  EntryComponent,
}: RenderRootParams<TServerSideProps>) => {
  const root = document.getElementById(rootId);

  if (root) {
    const serverSideProps: TServerSideProps = JSON.parse(root.getAttribute('data-props') as string);

    yup.setLocale(locale);

    ReactDOM.render(
      <React.StrictMode>
        <EntryComponent serverSideProps={serverSideProps} />
      </React.StrictMode>,
      root
    );
  }
};
