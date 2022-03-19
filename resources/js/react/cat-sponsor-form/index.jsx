import React, { useState } from 'react';
import clsx from 'clsx';
import { useForm, FormProvider } from 'react-hook-form';
import { Step1 } from './step-1';
import { Step3 } from './step-3';
import { Step2 } from './step-2';

const steps = {
  1: {
    label: 'Podatki botrstva',
  },
  2: {
    label: 'Vaši podatki',
  },
  3: {
    label: 'Zaključek',
  },
};

export function CatSponsorForm({ props }) {
  const { countryList } = props;
  const [activeStep, setActiveStep] = useState(1);

  const methods = useForm();

  const goToNextStep = () => {
    setActiveStep(activeStep + 1);
  };

  const goToPrevStep = () => {
    setActiveStep(activeStep - 1);
  };

  const onSubmit = (data) => {
    console.log(data);
  };

  const sharedStepProps = {
    onPrev: goToPrevStep,
    onNext: goToNextStep,
  };

  return (
    <div>
      <div className="flex justify-between lg:hidden">
        <div>{steps[activeStep].label}</div>
        <div>{`Korak ${activeStep}/3`}</div>
      </div>

      <div className="hidden lg:flex space-x-3">
        {Object.keys(steps).map((step) => (
          <div className="flex items-center space-x-2" key={step}>
            <div className={clsx(activeStep === Number(step) && 'font-extrabold')}>{step}</div>
            <div className={clsx(activeStep === Number(step) && 'underline')}>
              {steps[step].label}
            </div>
          </div>
        ))}
      </div>

      <FormProvider {...methods}>
        <form onSubmit={methods.handleSubmit(onSubmit)}>
          {activeStep === 1 && <Step1 {...sharedStepProps} />}
          {activeStep === 2 && <Step2 {...sharedStepProps} countryList={countryList} />}
          {activeStep === 3 && <Step3 {...sharedStepProps} />}
        </form>
      </FormProvider>
    </div>
  );
}
