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
