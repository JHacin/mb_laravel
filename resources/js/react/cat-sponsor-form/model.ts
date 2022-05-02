import { SelectOption } from '../types';

export enum Step {
  SPONSORSHIP_PARAMS = 'sponsorshipParams',
  PAYER_DETAILS = 'payerDetails',
  GIFTEE_DETAILS = 'gifteeDetails',
  SUMMARY = 'summary',
}

export const stepConfig: Record<Step, { label: string }> = {
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

export const stepsWithGift: Step[] = [
  Step.SPONSORSHIP_PARAMS,
  Step.PAYER_DETAILS,
  Step.GIFTEE_DETAILS,
  Step.SUMMARY,
];

export const stepsWithoutGift: Step[] = stepsWithGift.filter(
  (step) => step !== Step.GIFTEE_DETAILS
);

export const isGiftOptions: SelectOption[] = [
  { label: 'Boter bom jaz', value: false, key: 'false' },
  { label: 'Botrstvo želim podariti', value: true, key: 'true' },
];

export const amountOptions: SelectOption[] = [
  { label: '5€', value: 5, key: '5' },
  { label: '10€', value: 10, key: '10' },
  { label: '20€', value: 20, key: '20' },
  { label: '50€', value: 50, key: '50' },
];

export const durationOptions: SelectOption[] = [
  { label: '1 mesec', value: 1, key: '1' },
  { label: '3 meseci', value: 3, key: '3' },
  { label: '6 mesecev', value: 6, key: '6' },
  { label: '12 mesecev', value: 12, key: '12' },
];
