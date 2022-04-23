export const initialValues = {
  is_gift: false,
  wants_direct_debit: false,
  is_anonymous: false,
  monthly_amount: 5,
  duration: 12,
  payer_email: '',
  payer_first_name: '',
  payer_last_name: '',
  payer_gender: 'female',
  payer_address: '',
  payer_zip_code: '',
  payer_city: '',
  payer_country: 'SI',
  giftee_email: '',
  giftee_first_name: '',
  giftee_last_name: '',
  giftee_gender: 'female',
  giftee_address: '',
  giftee_zip_code: '',
  giftee_city: '',
  giftee_country: 'SI',
};

export const isGiftOptions = [
  { label: 'Boter bom jaz', value: false },
  { label: 'Botrstvo želim podariti', value: true },
];

export const monthlyAmountOptions = [
  { label: '5€', value: 5 },
  { label: '10€', value: 10 },
  { label: '20€', value: 20 },
  { label: '50€', value: 50 },
];

export const durationOptions = [
  { label: '1 mesec', value: 1 },
  { label: '3 meseci', value: 3 },
  { label: '6 mesecev', value: 6 },
  { label: '12 mesecev', value: 12 },
];

export const genderOptions = [
  { label: 'Ženska', value: 'female' },
  { label: 'Moški', value: 'male' },
];
