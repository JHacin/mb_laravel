import { ServerSideProps } from './types';
import { SpecialSponsorshipForm } from './special-sponsorship-form';
import { renderRoot } from '../sponsorship-forms/util';

renderRoot<ServerSideProps>({
  rootId: 'react-root__special-sponsorship-form',
  EntryComponent: SpecialSponsorshipForm,
});
