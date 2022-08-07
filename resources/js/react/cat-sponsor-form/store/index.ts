import { createFormStore } from '../../sponsorship-forms/store';
import { AnyStepFields, CatSponsorshipFormStoreValues } from '../types';
import { DEFAULT_COUNTRY, DEFAULT_GENDER } from '../../sponsorship-forms/constants';

export const useCatSponsorshipFormStore = createFormStore<
  CatSponsorshipFormStoreValues,
  AnyStepFields
>({
  initialValues: {
    is_gift: false,
    wants_direct_debit: false,
    is_anonymous: false,
    monthly_amount: 5,
    requested_duration: null,
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
