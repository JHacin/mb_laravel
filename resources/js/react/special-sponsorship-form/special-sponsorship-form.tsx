import React, { FC, useEffect, useRef, useState } from 'react';
import { ServerSideProps, SharedStepProps } from './types';
import axios from 'axios';
import { Transition, TransitionStatus } from 'react-transition-group';
import { ENTERED, ENTERING, EXITED, EXITING } from 'react-transition-group/Transition';
import clsx from 'clsx';
import { SponsorshipParamsStep } from './steps/sponsorship-params-step';
import { SummaryStep } from './steps/summary-step';
import { STEP_CONFIG, STEPS_WITH_GIFT, STEPS_WITHOUT_GIFT } from '../sponsorship-forms/constants';
import { Step } from '../sponsorship-forms/types';
import { useSpecialSponsorshipFormStore } from './store';
import { GifteeDetailsStep } from '../sponsorship-forms/components/giftee-details-step';
import { PayerDetailsStep } from '../sponsorship-forms/components/payer-details-step'

interface SpecialSponsorshipFormProps {
  serverSideProps: ServerSideProps;
}

export const SpecialSponsorshipForm: FC<SpecialSponsorshipFormProps> = ({ serverSideProps }) => {
  const { values, updateStatus, status, updateValues } = useSpecialSponsorshipFormStore();
  const [activeStep, setActiveStep] = useState(Step.SPONSORSHIP_PARAMS);
  const scrollRef = useRef<HTMLDivElement>(null);
  const sponsorshipParamsStepRef = useRef<HTMLElement>(null);
  const payerDetailsStepRef = useRef<HTMLElement>(null);
  const gifteeDetailsStepRef = useRef<HTMLElement>(null);
  const summaryStepRef = useRef<HTMLElement>(null);

  const availableSteps = values.is_gift ? STEPS_WITH_GIFT : STEPS_WITHOUT_GIFT;
  const activeStepIndex = availableSteps.findIndex((step) => step === activeStep);

  const goToNextStep = () => {
    setActiveStep(availableSteps[activeStepIndex + 1]);
  };

  const goToPrevStep = () => {
    setActiveStep(availableSteps[activeStepIndex - 1]);
  };

  const onFinalSubmit = async () => {
    updateStatus({ isSubmitting: true, isSubmitError: false });

    try {
      await axios.post(serverSideProps.requestUrl, values);
      updateStatus({ isSubmitSuccess: true });
    } catch (error: unknown) {
      updateStatus({ isSubmitError: true });
    }

    updateStatus({ isSubmitting: false });
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

  const stepComponents = [
    {
      step: Step.SPONSORSHIP_PARAMS,
      content: <SponsorshipParamsStep {...sharedStepProps} />,
      ref: sponsorshipParamsStepRef,
    },
    {
      step: Step.PAYER_DETAILS,
      content: <PayerDetailsStep {...sharedStepProps} values={values} updateValues={updateValues} />,
      ref: payerDetailsStepRef,
    },
    {
      step: Step.GIFTEE_DETAILS,
      content: (
        <GifteeDetailsStep {...sharedStepProps} values={values} updateValues={updateValues} />
      ),
      ref: gifteeDetailsStepRef,
    },
    {
      step: Step.SUMMARY,
      content: <SummaryStep {...sharedStepProps} />,
      ref: summaryStepRef,
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
  }, [activeStep, status.isSubmitSuccess]);

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
        {stepComponents.map(({ step, content, ref }) => (
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
                {activeStep === step && content}
              </div>
            )}
          </Transition>
        ))}
      </div>
    </div>
  );
};
