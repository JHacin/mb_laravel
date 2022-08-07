import { CatSponsorForm } from './cat-sponsor-form';
import { renderRoot } from '../sponsorship-forms/util';
import { ServerSideProps } from './types'

renderRoot<ServerSideProps>({
  rootId: 'react-root__cat-sponsor-form',
  EntryComponent: CatSponsorForm,
});
