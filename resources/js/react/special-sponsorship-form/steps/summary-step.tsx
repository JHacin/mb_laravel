import React, { FC } from 'react';
import { useController, useForm } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup/dist/yup';
import * as yup from 'yup';
import { SharedStepProps, SummaryStepFields } from '../types';
import { ButtonRow } from '../../components/button-row';
import { BackButton } from '../../components/back-button';
import { HookFormCheckbox } from '../../components/hook-form-checkbox';
import { SubmitButton } from '../../components/submit-button';
import { useSpecialSponsorshipFormStore } from '../store';
import { YupValidationSchemaShape } from '../../sponsorship-forms/types';
import { useStoreValuesSync } from '../../sponsorship-forms/store/use-store-values-sync';
import { FORM_MODE } from '../../sponsorship-forms/constants';

export const SummaryStep: FC<SharedStepProps> = ({ onPrev, onFinalSubmit, contactEmail }) => {
  const {
    values,
    status: { isSubmitting, isSubmitSuccess, isSubmitError },
    updateValues,
  } = useSpecialSponsorshipFormStore();

  const validationSchema = yup.object<YupValidationSchemaShape<SummaryStepFields>>({
    is_agreed_to_terms: yup
      .boolean()
      .oneOf([true], 'Prosimo označite, da se strinjate z zgoraj navedenim.'),
  });

  const { handleSubmit, watch, control } = useForm<SummaryStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useStoreValuesSync<SummaryStepFields>({ watch, callback: updateValues });

  const isAgreedToTermsControl = useController({
    name: 'is_agreed_to_terms',
    control,
    defaultValue: values.is_agreed_to_terms,
  });

  const onSubmit = (data: SummaryStepFields) => {
    updateValues(data);
    onFinalSubmit();
  };

  return (
    <div className="p-5">
      {!isSubmitSuccess && (
        <form onSubmit={handleSubmit(onSubmit)}>
          <div className="mb-form-group">
            <HookFormCheckbox label="Strinjam se" control={isAgreedToTermsControl} />
          </div>

          {isSubmitError && (
            <div className="bg-danger/20 p-4 space-y-4">
              <div>
                Pri pošiljanju podatkov je žal prišlo do napake. Prosimo, poskusite ponovno.
              </div>
              <div>
                Če se napaka ponovi, nam prosim pišite na{' '}
                <a href={`mailto:${contactEmail}`} className="mb-link font-bold">
                  {contactEmail}
                </a>
                .
              </div>
            </div>
          )}

          <ButtonRow>
            <BackButton onClick={onPrev} />
            <SubmitButton
              isLoading={isSubmitting}
              startIcon={isSubmitting ? null : <i className="fa-solid fa-paper-plane" />}
            >
              {isSubmitting ? 'Pošiljam...' : 'Pošlji'}
            </SubmitButton>
          </ButtonRow>
        </form>
      )}

      {isSubmitSuccess && (
        <div className="bg-success/50 p-4 space-y-4">
          <div className="font-bold text-lg">Hvala!</div>
          <div>Na vaš e-mail naslov vam bomo poslali navodila za zaključek postopka.</div>
        </div>
      )}
    </div>
  );
};
