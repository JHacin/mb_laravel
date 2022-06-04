import React, { FC } from 'react';
import { useController, useForm } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup/dist/yup';
import * as yup from 'yup';
import { useGlobalFormDataUpdate } from '../hooks/use-global-form-data-update';
import { FORM_MODE } from '../constants';
import { useGlobalState } from '../hooks/use-global-state';
import { BackButton } from '../components/back-button';
import { SubmitButton } from '../components/submit-button';
import { ButtonRow } from '../components/button-row';
import { SharedStepProps, SummaryStepFields } from '../types';
import { YupValidationSchemaShape } from '../../types';
import { HookFormCheckbox } from '../components/hook-form-checkbox';

export const SummaryStep: FC<SharedStepProps> = ({ onPrev, onFinalSubmit }) => {
  const {
    actions,
    state: {
      formData,
      formState: { isSubmitting, apiErrors, hasSubmittedSuccessfully },
    },
  } = useGlobalState();

  const validationSchema = yup.object<YupValidationSchemaShape<SummaryStepFields>>({
    is_agreed_to_terms: yup
      .boolean()
      .oneOf([true], 'Prosimo označite, da se strinjate z zgoraj navedenim.'),
  });

  const { handleSubmit, watch, control } = useForm<SummaryStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useGlobalFormDataUpdate({ watch, actions });

  const isAgreedToTermsControl = useController({
    name: 'is_agreed_to_terms',
    control,
    defaultValue: formData.is_agreed_to_terms,
  });

  const onSubmit = (data: SummaryStepFields) => {
    actions.updateFormDataAction(data);
    onFinalSubmit();
  };

  if (hasSubmittedSuccessfully) {
    return (
      <div className="space-y-4">
        <div className="font-bold text-lg">Hvala!</div>
        <div>Na vaš e-mail naslov vam bomo poslali navodila za zaključek postopka.</div>
      </div>
    );
  }

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <HookFormCheckbox label="Strinjam se" control={isAgreedToTermsControl} />
      </div>

      {apiErrors && (
        <div className="mb-form-group">
          {Object.keys(apiErrors).map((fieldName) => (
            <div key={fieldName}>
              <div>{fieldName}:</div>
              <div>
                <ul>
                  {apiErrors[fieldName].map((errorMessage) => (
                    <li key={errorMessage}>{errorMessage}</li>
                  ))}
                </ul>
              </div>
              <hr />
            </div>
          ))}
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
  );
};
