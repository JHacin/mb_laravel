import { BoxOptionItem } from '../../types';
import { Step } from '../types';

export const FORM_MODE = 'all';

export const STEP_CONFIG: Record<Step, { label: string }> = {
  [Step.SPONSORSHIP_PARAMS]: {
    label: 'Botrstvo',
  },
  [Step.PAYER_DETAILS]: {
    label: 'Plačnik',
  },
  [Step.GIFTEE_DETAILS]: {
    label: 'Obdarovanec',
  },
  [Step.SUMMARY]: {
    label: 'Zaključek',
  },
};

export const STEPS_WITH_GIFT: Step[] = [
  Step.SPONSORSHIP_PARAMS,
  Step.PAYER_DETAILS,
  Step.GIFTEE_DETAILS,
  Step.SUMMARY,
];

export const STEPS_WITHOUT_GIFT: Step[] = STEPS_WITH_GIFT.filter(
  (step) => step !== Step.GIFTEE_DETAILS
);

export const IS_GIFT_OPTIONS: BoxOptionItem[] = [
  { label: 'Boter bom jaz', value: false, key: 'false' },
  { label: 'Botrstvo želim podariti', value: true, key: 'true' },
];

export const AMOUNT_OPTIONS: BoxOptionItem[] = [
  { label: '5€', value: 5, key: '5' },
  { label: '10€', value: 10, key: '10' },
  { label: '20€', value: 20, key: '20' },
  { label: '50€', value: 50, key: '50' },
];

export const REQUESTED_DURATION_OPTIONS: BoxOptionItem[] = [
  { label: 'Do preklica', value: null, key: 'null' },
  { label: '1 mesec', value: 1, key: '1' },
  { label: '6 mesecev', value: 6, key: '6' },
  { label: '1 leto', value: 12, key: '12' },
];
