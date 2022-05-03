import React, { FC } from 'react';
import { useController, useForm } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup/dist/yup';
import * as yup from 'yup';
import { useGlobalFormDataUpdate } from '../hooks/use-global-form-data-update';
import { Checkbox } from '../../components/checkbox';
import { FORM_MODE } from '../constants';
import { useGlobalState } from '../hooks/use-global-state';
import { Error } from '../../components/error';
import { BackButton } from '../components/back-button';
import { SubmitButton } from '../components/submit-button';
import { ButtonRow } from '../components/button-row';
import { SharedStepProps, SummaryStepFields } from '../types';
import { YupValidationSchemaShape } from '../../types';

export const SummaryStep: FC<SharedStepProps> = ({ onPrev, onFinalSubmit }) => {
  const {
    actions,
    state: {
      formData,
      formState: { isSubmitting },
    },
  } = useGlobalState();

  const validationSchema = yup.object<YupValidationSchemaShape<SummaryStepFields>>({
    is_agreed_to_terms: yup
      .boolean()
      .oneOf([true], 'Prosimo označite, da se strinjate z zgoraj navedenim.'),
  });

  const {
    handleSubmit,
    watch,
    control,
    formState: { errors },
  } = useForm<SummaryStepFields>({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  useGlobalFormDataUpdate({ watch, actions });

  const { field: isAgreedToTermsControl } = useController({
    name: 'is_agreed_to_terms',
    control,
    defaultValue: formData.is_agreed_to_terms,
  });

  const onSubmit = (data: SummaryStepFields) => {
    actions.updateFormDataAction(data);
    onFinalSubmit();
  };

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <Checkbox
          label="Strinjam se"
          id="is_agreed_to_terms"
          onChange={isAgreedToTermsControl.onChange}
          value={isAgreedToTermsControl.value}
          ref={isAgreedToTermsControl.ref}
        />
        {errors.is_agreed_to_terms && <Error>{errors.is_agreed_to_terms.message}</Error>}
      </div>

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
