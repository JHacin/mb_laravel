import { createFormStore } from '../../sponsorship-forms/store';
import { DEFAULT_COUNTRY, DEFAULT_GENDER } from '../../sponsorship-forms/constants';
import { AnyStepFields, SpecialSponsorshipFormStoreValues } from '../types';

export const useSpecialSponsorshipFormStore = createFormStore<
  SpecialSponsorshipFormStoreValues,
  AnyStepFields
>({
  initialValues: {
    type: 0, // Todo: move to context wrapper
    // type: Number(serverSideProps.sponsorshipTypes.default),
    is_gift: false,
    is_anonymous: false,
    donation_amount: 0, // Todo
    // donation_amount: serverSideProps.sponsorshipTypes.amounts[serverSideProps.sponsorshipTypes.default],
    payer_email: '',
    payer_first_name: '',
    payer_last_name: '',
    payer_gender: DEFAULT_GENDER,
    payer_address: '',
    payer_zip_code: '',
    payer_city: '',
    payer_country: DEFAULT_COUNTRY,
    giftee_email: '',
    giftee_first_name: '',
    giftee_last_name: '',
    giftee_gender: DEFAULT_GENDER,
    giftee_address: '',
    giftee_zip_code: '',
    giftee_city: '',
    giftee_country: DEFAULT_COUNTRY,
    is_agreed_to_terms: false,
  },
});
