import { useSponsorshipFormStore } from '../../sponsorship-forms/store';
import { CatSponsorshipFormStore } from '../types';

export const useCatSponsorshipFormStore = () => useSponsorshipFormStore<CatSponsorshipFormStore>();
