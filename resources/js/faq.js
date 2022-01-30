function handleAccordionToggling() {
  const accordionTriggers = document.querySelectorAll('[data-accordion-trigger]');

  for (let i = 0; i < accordionTriggers.length; i += 1) {
    accordionTriggers[i].addEventListener('click', () => {
      const accordionContent = accordionTriggers[i].nextElementSibling;
      const icon = accordionTriggers[i].querySelector('svg');

      const isOpen = accordionContent.getAttribute('data-accordion-content-state') === 'open';

      if (isOpen) {
        accordionContent.style.maxHeight = '0px';
        accordionContent.setAttribute('data-accordion-content-state', 'closed');
        icon.setAttribute('data-icon', 'plus')
      } else {
        accordionContent.style.maxHeight = `${accordionContent.scrollHeight}px`;
        accordionContent.setAttribute('data-accordion-content-state', 'open');
        icon.setAttribute('data-icon', 'minus')
      }
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  handleAccordionToggling();
});
