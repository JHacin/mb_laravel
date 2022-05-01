import React from 'react';
import { useController, useForm } from 'react-hook-form';
import { yupResolver } from '@hookform/resolvers/yup/dist/yup';
import * as yup from 'yup';
import { useGlobalSync } from './hooks/use-global-sync';
import { Checkbox } from '../components/checkbox';
import { FORM_MODE } from './constants';
import { useGlobalState } from './hooks/use-global-state';
import { Button } from '../components/button';
import { Error } from '../components/error';

export function SummaryStep({ onPrev, onFinalSubmit }) {
  const { actions, state } = useGlobalState();

  const validationSchema = yup.object({
    is_agreed_to_terms: yup
      .boolean()
      .oneOf([true], 'Prosimo označite, da se strinjate z zgoraj navedenim.'),
  });

  const {
    handleSubmit,
    watch,
    control,
    formState: { errors },
  } = useForm({
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
    onFinalSubmit();
  };

  useGlobalSync({ watch });

  return (
    <form onSubmit={handleSubmit(onSubmit)}>
      <div className="mb-form-group">
        <Checkbox
          label="Strinjam se"
          id="is_agreed_to_terms"
          onChange={isAgreedToTermsControl.onChange}
          value={isAgreedToTermsControl.value}
        />
        {errors.is_agreed_to_terms && <Error>{errors.is_agreed_to_terms.message}</Error>}
      </div>

      <Button type="button" color="secondary" onClick={onPrev}>
        Nazaj
      </Button>

      <Button type="submit" color="primary">
        {state.formState.isSubmitting ? '...' : 'Potrdi'}
      </Button>
    </form>
  );
}
