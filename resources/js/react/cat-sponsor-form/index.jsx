import React, { useState, useRef, useEffect } from 'react';
import clsx from 'clsx';
import { useStateMachine } from 'little-state-machine';
import { setLocale } from 'yup';
import { Transition } from 'react-transition-group';
import { SponsorshipParamsStep } from './sponsorship-params-step';
import { SummaryStep } from './summary-step';
import { PayerDetailsStep } from './payer-details-step';
import { GifteeDetailsStep } from './giftee-details-step';
import { stepsWithGift, stepsWithoutGift, stepConfig, Step } from './model';
import { locale } from './yup-locale';

setLocale(locale);

export function CatSponsorForm({ props }) {
  const { countryList } = props;
  const { state } = useStateMachine();
  const [activeStep, setActiveStep] = useState(Step.SPONSORSHIP_PARAMS);
  const scrollRef = useRef(null);

  const availableSteps = state.formData.is_gift ? stepsWithGift : stepsWithoutGift;
  const activeStepIndex = availableSteps.findIndex((step) => step === activeStep);

  const goToNextStep = () => {
    setActiveStep(availableSteps[activeStepIndex + 1]);
  };

  const goToPrevStep = () => {
    setActiveStep(availableSteps[activeStepIndex - 1]);
  };

  const scrollBackToTop = () => {
    if (!scrollRef.current) {
      return;
    }

    const { top } = scrollRef.current.getBoundingClientRect();
    const isScrolledBelowTop = top < 0;

    if (isScrolledBelowTop) {
      scrollRef.current.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
  };

  const sharedStepProps = {
    onPrev: goToPrevStep,
    onNext: goToNextStep,
    countryList,
  };

  const stepComponents = [
    { step: Step.SPONSORSHIP_PARAMS, Component: SponsorshipParamsStep },
    { step: Step.PAYER_DETAILS, Component: PayerDetailsStep },
    { step: Step.GIFTEE_DETAILS, Component: GifteeDetailsStep },
    { step: Step.SUMMARY, Component: SummaryStep },
  ];

  const transitionDuration = 300;

  const transitionStyles = {
    entering: {
      opacity: 1,
    },
    entered: {
      opacity: 1,
    },
    exiting: {
      opacity: 0,
    },
    exited: {
      opacity: 0,
    },
  };

  useEffect(() => {
    scrollBackToTop();
  }, [activeStep]);

  return (
    <div className="border border-gray-semi" ref={scrollRef}>
      <div className="flex justify-between lg:hidden px-4 pt-4 text-sm text-gray-semi">
        <div>{stepConfig[activeStep].label}</div>
        <div>{`Korak ${activeStepIndex + 1}/${availableSteps.length}`}</div>
      </div>

      <div className="hidden lg:flex space-x-4 bg-gray-extralight p-5">
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

      <div className="p-5">
        {stepComponents.map(({ step, Component }) => (
          <Transition in={activeStep === step} timeout={transitionDuration}>
            {(transitionState) => (
              <div
                style={{
                  transition: `opacity ${transitionDuration}ms ease-in-out`,
                  opacity: 0,
                  ...transitionStyles[transitionState],
                }}
              >
                {activeStep === step && <Component {...sharedStepProps} />}
              </div>
            )}
          </Transition>
        ))}
      </div>
    </div>
  );
}
