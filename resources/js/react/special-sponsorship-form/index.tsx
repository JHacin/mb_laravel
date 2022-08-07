import { AnyStepFields, ServerSideProps, SpecialSponsorshipFormStoreValues } from './types';
import { SpecialSponsorshipForm } from './special-sponsorship-form';
import { getServerSideProps, renderRoot } from '../sponsorship-forms/util';
import { createFormStore } from '../sponsorship-forms/store';

const rootId = 'react-root__special-sponsorship-form';

const serverSideProps = getServerSideProps<ServerSideProps>({ rootId });
const { sponsorshipTypes, gender, countryList } = serverSideProps;

const store = createFormStore<SpecialSponsorshipFormStoreValues, AnyStepFields>({
  initialValues: {
    type: Number(sponsorshipTypes.default),
    is_gift: false,
    is_anonymous: false,
    donation_amount: sponsorshipTypes.amounts[sponsorshipTypes.default],
    payer_email: '',
    payer_first_name: '',
    payer_last_name: '',
    payer_gender: gender.default,
    payer_address: '',
    payer_zip_code: '',
    payer_city: '',
    payer_country: countryList.default,
    giftee_email: '',
    giftee_first_name: '',
    giftee_last_name: '',
    giftee_gender: gender.default,
    giftee_address: '',
    giftee_zip_code: '',
    giftee_city: '',
    giftee_country: countryList.default,
    is_agreed_to_terms: false,
  },
});

renderRoot<ServerSideProps, SpecialSponsorshipFormStoreValues, AnyStepFields>({
  rootId,
  EntryComponent: SpecialSponsorshipForm,
  serverSideProps,
  storeContextValue: store,
});
