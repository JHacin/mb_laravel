import { useSponsorshipFormStore } from '../../sponsorship-forms/store';
import { SpecialSponsorshipFormStore } from '../types';

export const useSpecialSponsorshipFormStore = () =>
  useSponsorshipFormStore<SpecialSponsorshipFormStore>();
