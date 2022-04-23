import React, { useState } from 'react';
import clsx from 'clsx';
import { createStore, StateMachineProvider } from 'little-state-machine';
import { SponsorshipParamsStep } from './sponsorship-params-step';
import { SummaryStep } from './summary-step';
import { PayerDetailsStep } from './payer-details-step';
import { initialValues } from './model';

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

createStore({
  formData: initialValues,
});

export function CatSponsorForm({ props }) {
  const { countryList } = props;
  const [activeStep, setActiveStep] = useState(1);

  const goToNextStep = () => {
    setActiveStep(activeStep + 1);
  };

  const goToPrevStep = () => {
    setActiveStep(activeStep - 1);
  };

  const sharedStepProps = {
    onPrev: goToPrevStep,
    onNext: goToNextStep,
  };

  return (
    <div className="border border-gray-semi">
      <StateMachineProvider>
        <div className="flex justify-between lg:hidden px-4 pt-4 text-sm text-gray-semi">
          <div>{steps[activeStep].label}</div>
          <div>{`Korak ${activeStep}/3`}</div>
        </div>

        <div className="hidden lg:flex space-x-3 bg-gray-extralight p-4">
          {Object.keys(steps).map((step) => {
            const isActive = activeStep === Number(step);

            return (
              <div className="flex items-center space-x-2" key={step}>
                <div
                  className={clsx(
                    'border rounded-full w-5 h-5 flex justify-center items-center',
                    isActive && 'bg-primary border-primary text-white',
                    !isActive && 'text-gray-semi border-gray-semi'
                  )}
                >
                  {step}
                </div>
                <div className={clsx(!isActive && 'text-gray-semi', isActive && 'text-gray-dark')}>
                  {steps[step].label}
                </div>
              </div>
            );
          })}
        </div>

        <div className="p-4">
          {activeStep === 1 && <SponsorshipParamsStep {...sharedStepProps} />}
          {activeStep === 2 && <PayerDetailsStep {...sharedStepProps} countryList={countryList} />}
          {activeStep === 3 && <SummaryStep {...sharedStepProps} />}
        </div>
      </StateMachineProvider>
    </div>
  );
}
