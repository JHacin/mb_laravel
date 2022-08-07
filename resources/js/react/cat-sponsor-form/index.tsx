import { CatSponsorForm } from './cat-sponsor-form';
import { getServerSideProps, renderRoot } from '../sponsorship-forms/util';
import { AnyStepFields, CatSponsorshipFormStoreValues, ServerSideProps } from './types';
import { createFormStore } from '../sponsorship-forms/store';

const rootId = 'react-root__cat-sponsor-form';

const serverSideProps = getServerSideProps<ServerSideProps>({ rootId });

const store = createFormStore<CatSponsorshipFormStoreValues, AnyStepFields>({
  initialValues: {
    is_gift: false,
    wants_direct_debit: false,
    is_anonymous: false,
    monthly_amount: 5,
    requested_duration: null,
    payer_email: '',
    payer_first_name: '',
    payer_last_name: '',
    payer_gender: serverSideProps.gender.default,
    payer_address: '',
    payer_zip_code: '',
    payer_city: '',
    payer_country: serverSideProps.countryList.default,
    giftee_email: '',
    giftee_first_name: '',
    giftee_last_name: '',
    giftee_gender: serverSideProps.gender.default,
    giftee_address: '',
    giftee_zip_code: '',
    giftee_city: '',
    giftee_country: serverSideProps.countryList.default,
    is_agreed_to_terms: false,
  },
});

renderRoot<ServerSideProps, CatSponsorshipFormStoreValues, AnyStepFields>({
  rootId,
  EntryComponent: CatSponsorForm,
  serverSideProps,
  storeContextValue: store,
});
