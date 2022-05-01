export const Step = {
  SPONSORSHIP_PARAMS: 'sponsorshipParams',
  PAYER_DETAILS: 'payerDetails',
  GIFTEE_DETAILS: 'gifteeDetails',
  SUMMARY: 'summary',
};

export const stepConfig = {
  [Step.SPONSORSHIP_PARAMS]: {
    label: 'Podatki botrstva',
  },
  [Step.PAYER_DETAILS]: {
    label: 'Podatki plačnika',
  },
  [Step.GIFTEE_DETAILS]: {
    label: 'Podatki obdarovanca',
  },
  [Step.SUMMARY]: {
    label: 'Zaključek',
  },
};

export const stepsWithGift = [
  Step.SPONSORSHIP_PARAMS,
  Step.PAYER_DETAILS,
  Step.GIFTEE_DETAILS,
  Step.SUMMARY,
];

export const stepsWithoutGift = stepsWithGift.filter((step) => step !== Step.GIFTEE_DETAILS);

export const isGiftOptions = [
  { label: 'Boter bom jaz', value: false },
  { label: 'Botrstvo želim podariti', value: true },
];

export const amountOptions = [
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
