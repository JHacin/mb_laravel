import React, { FC, MutableRefObject, useEffect, useRef, useState } from 'react';
import { ServerSideProps, SharedStepProps, Step } from './types';
import { useGlobalState } from './hooks/use-global-state';
import { STEP_CONFIG, STEPS_WITH_GIFT, STEPS_WITHOUT_GIFT } from './constants';
import axios from 'axios';
import { Transition, TransitionStatus } from 'react-transition-group';
import { ENTERED, ENTERING, EXITED, EXITING } from 'react-transition-group/Transition';
import clsx from 'clsx';
import { SponsorshipParamsStep } from './steps/sponsorship-params-step';
import { PayerDetailsStep } from './steps/payer-details-step';
import { GifteeDetailsStep } from './steps/giftee-details-step';
import { SummaryStep } from './steps/summary-step';

interface SpecialSponsorshipFormProps {
  serverSideProps: ServerSideProps;
}

export const SpecialSponsorshipForm: FC<SpecialSponsorshipFormProps> = ({ serverSideProps }) => {
  const {
    state: { formState, formData },
    actions,
  } = useGlobalState();
  const [activeStep, setActiveStep] = useState(Step.SPONSORSHIP_PARAMS);
  const scrollRef = useRef<HTMLDivElement>(null);
  const sponsorshipParamsStepRef = useRef<HTMLElement>(null);
  const payerDetailsStepRef = useRef<HTMLElement>(null);
  const gifteeDetailsStepRef = useRef<HTMLElement>(null);
  const summaryStepRef = useRef<HTMLElement>(null);

  const availableSteps = formData.is_gift ? STEPS_WITH_GIFT : STEPS_WITHOUT_GIFT;
  const activeStepIndex = availableSteps.findIndex((step) => step === activeStep);

  const goToNextStep = () => {
    setActiveStep(availableSteps[activeStepIndex + 1]);
  };

  const goToPrevStep = () => {
    setActiveStep(availableSteps[activeStepIndex - 1]);
  };

  const onFinalSubmit = async () => {
    actions.updateFormStateAction({ isSubmitting: true, isSubmitError: false });

    try {
      await axios.post(serverSideProps.requestUrl, formData);
      actions.updateFormStateAction({ isSubmitSuccess: true });
    } catch (error: unknown) {
      actions.updateFormStateAction({ isSubmitError: true });
    }

    actions.updateFormStateAction({ isSubmitting: false });
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

  const sharedStepProps: SharedStepProps = {
    onPrev: goToPrevStep,
    onNext: goToNextStep,
    onFinalSubmit,
    countryOptions: Object.keys(serverSideProps.countryList.options).map((countryCode) => ({
      label: serverSideProps.countryList.options[countryCode],
      value: countryCode,
      key: countryCode,
    })),
    genderOptions: Object.keys(serverSideProps.gender.options).map((genderEnumValue) => ({
      label: serverSideProps.gender.options[genderEnumValue],
      value: Number(genderEnumValue),
      key: String(genderEnumValue),
    })),
    typeOptions: Object.keys(serverSideProps.sponsorshipTypes.options).map((type) => ({
      label: serverSideProps.sponsorshipTypes.options[type],
      value: Number(type),
      key: String(type),
    })),
    typeAmounts: serverSideProps.sponsorshipTypes.amounts,
    validationConfig: serverSideProps.validationConfig,
    contactEmail: serverSideProps.contactEmail,
  };

  const stepComponents: {
    step: Step;
    Component: FC<SharedStepProps>;
    props: SharedStepProps;
    ref: MutableRefObject<HTMLElement | null>;
  }[] = [
    {
      step: Step.SPONSORSHIP_PARAMS,
      Component: SponsorshipParamsStep,
      ref: sponsorshipParamsStepRef,
      props: sharedStepProps,
    },
    {
      step: Step.PAYER_DETAILS,
      Component: PayerDetailsStep,
      ref: payerDetailsStepRef,
      props: sharedStepProps,
    },
    {
      step: Step.GIFTEE_DETAILS,
      Component: GifteeDetailsStep,
      ref: gifteeDetailsStepRef,
      props: sharedStepProps,
    },
    {
      step: Step.SUMMARY,
      Component: SummaryStep,
      ref: summaryStepRef,
      props: sharedStepProps,
    },
  ];

  const transitionDuration = 300;

  const transitionStyles: Partial<Record<TransitionStatus, { opacity: number }>> = {
    [ENTERING]: {
      opacity: 1,
    },
    [ENTERED]: {
      opacity: 1,
    },
    [EXITING]: {
      opacity: 0,
    },
    [EXITED]: {
      opacity: 0,
    },
  };

  useEffect(() => {
    scrollBackToTop();
  }, [activeStep, formState.isSubmitSuccess]);

  return (
    <div className="border border-gray-semi/50 shadow-lg" ref={scrollRef}>
      <div className="flex justify-between lg:hidden px-4 pt-4 text-sm text-gray-semi">
        <div>{STEP_CONFIG[activeStep].label}</div>
        <div>{`Korak ${activeStepIndex + 1}/${availableSteps.length}`}</div>
      </div>

      <div className="hidden lg:flex space-x-4 bg-gray-extralight border-b border-gray-light px-5 py-4">
        {availableSteps.map((step, index) => {
          const isActive = activeStep === step;

          return (
            <div className="flex items-center space-x-2" key={step}>
              <div
                className={clsx(
                  'border rounded-full w-5 h-5 flex justify-center items-center text-sm',
                  isActive && 'bg-primary border-primary text-white',
                  !isActive && 'text-gray-semi border-gray-semi'
                )}
              >
                {index + 1}
              </div>
              <div
                className={clsx(
                  'text-sm',
                  !isActive && 'text-gray-semi',
                  isActive && 'text-gray-dark'
                )}
              >
                {STEP_CONFIG[step].label}
              </div>
            </div>
          );
        })}
      </div>

      <div>
        {stepComponents.map(({ step, Component, props, ref }) => (
          <Transition
            in={activeStep === step}
            timeout={transitionDuration}
            key={step}
            nodeRef={ref}
          >
            {(transitionState) => (
              <div
                style={{
                  transition: `opacity ${transitionDuration}ms ease-in-out`,
                  opacity: 0,
                  ...transitionStyles[transitionState],
                }}
              >
                {activeStep === step && <Component {...props} />}
              </div>
            )}
          </Transition>
        ))}
      </div>
    </div>
  );
};
