import React from 'react';
import { useController, useForm } from 'react-hook-form';
import { useStateMachine } from 'little-state-machine';
import { yupResolver } from '@hookform/resolvers/yup/dist/yup';
import * as yup from 'yup';
import { updateFormDataAction } from './updateFormDataAction';
import { useGlobalSync } from './hooks/use-global-sync';
import { Checkbox } from '../components/checkbox';
import { FORM_MODE } from './constants';

export function SummaryStep({ onPrev }) {
  const { actions, state } = useStateMachine({ updateFormDataAction });

  const validationSchema = yup.object({
    is_agreed_to_terms: yup.boolean(),
  });

  const { handleSubmit, watch, control } = useForm({
    mode: FORM_MODE,
    resolver: yupResolver(validationSchema),
  });

  const { field: isAgreedToTermsControl } = useController({
    name: 'is_agreed_to_terms',
    control,
    defaultValue: state.formData.is_agreed_to_terms,
  });

  const onSubmit = (data) => {
    actions.updateFormDataAction(data);
  };

  useGlobalSync({ watch });

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <Checkbox
          label="Strinjam se"
          id="is_agreed_to_terms"
          onChange={isAgreedToTermsControl.onChange}
        />
      </div>

      <button type="button" className="mb-btn mb-btn-secondary" onClick={onPrev}>
        Nazaj
      </button>

      <button type="submit" className="mb-btn mb-btn-primary">
        Potrdi
      </button>
    </form>
  );
}
