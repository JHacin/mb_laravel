import React, { useState } from 'react';
import clsx from 'clsx';
import { useStateMachine } from 'little-state-machine';
import { SponsorshipParamsStep } from './sponsorship-params-step';
import { SummaryStep } from './summary-step';
import { PayerDetailsStep } from './payer-details-step';
import { GifteeDetailsStep } from './giftee-details-step';
import { stepsWithGift, stepsWithoutGift, stepConfig, Step } from './model';

export function CatSponsorForm({ props }) {
  const { countryList } = props;
  const { state } = useStateMachine();
  const [activeStep, setActiveStep] = useState(Step.SPONSORSHIP_PARAMS);

  const availableSteps = state.formData.is_gift ? stepsWithGift : stepsWithoutGift;
  const activeStepIndex = availableSteps.findIndex((step) => step === activeStep);

  const goToNextStep = () => {
    setActiveStep(availableSteps[activeStepIndex + 1]);
  };

  const goToPrevStep = () => {
    setActiveStep(availableSteps[activeStepIndex - 1]);
  };

  const sharedStepProps = {
    onPrev: goToPrevStep,
    onNext: goToNextStep,
    countryList,
  };

  return (
    <div className="border border-gray-semi">
      <div className="flex justify-between lg:hidden px-4 pt-4 text-sm text-gray-semi">
        <div>{stepConfig[activeStep].label}</div>
        <div>{`Korak ${activeStepIndex + 1}/${availableSteps.length}`}</div>
      </div>

      <div className="hidden lg:flex space-x-3 bg-gray-extralight p-4">
        {availableSteps.map((step, index) => {
          const isActive = activeStep === step;

          return (
            <div className="flex items-center space-x-2" key={step}>
              <div
                className={clsx(
                  'border rounded-full w-5 h-5 flex justify-center items-center',
                  isActive && 'bg-primary border-primary text-white',
                  !isActive && 'text-gray-semi border-gray-semi'
                )}
              >
                {index + 1}
              </div>
              <div className={clsx(!isActive && 'text-gray-semi', isActive && 'text-gray-dark')}>
                {stepConfig[step].label}
              </div>
            </div>
          );
        })}
      </div>

      <div className="p-4">
        {activeStep === Step.SPONSORSHIP_PARAMS && <SponsorshipParamsStep {...sharedStepProps} />}
        {activeStep === Step.PAYER_DETAILS && <PayerDetailsStep {...sharedStepProps} />}
        {activeStep === Step.GIFTEE_DETAILS && <GifteeDetailsStep {...sharedStepProps} />}
        {activeStep === Step.SUMMARY && <SummaryStep {...sharedStepProps} />}
      </div>
    </div>
  );
}
