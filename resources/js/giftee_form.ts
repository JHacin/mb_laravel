document.addEventListener('DOMContentLoaded', () => {
  function getForm() {
    return document.querySelector('.giftee-form') as HTMLElement;
  }

  function toggleFormVisibility(isGift: boolean) {
    getForm().style.display = isGift ? '' : 'none';
  }

  function toggleRequiredAttributes(isGift: boolean) {
    const fields = getForm().querySelectorAll<HTMLInputElement | HTMLSelectElement>(
      'input, select'
    );

    for (let i = 0; i < fields.length; i += 1) {
      fields[i].required = isGift;
    }
  }

  function isGiftRadioValue(radioValue: string) {
    return radioValue === 'yes';
  }

  (function setDefaultFormAttributes() {
    const checkedRadio = document.querySelector(
      'input[type="radio"][name="is_gift"]:checked'
    ) as HTMLInputElement;

    toggleFormVisibility(isGiftRadioValue(checkedRadio.value));
    toggleRequiredAttributes(isGiftRadioValue(checkedRadio.value));
  })();

  (function handleToggling() {
    const radios = document.querySelectorAll('input[type="radio"][name="is_gift"]');

    for (let i = 0; i < radios.length; i += 1) {
      radios[i].addEventListener('change', (event: any) => {
        toggleFormVisibility(isGiftRadioValue(event.target.value));
        toggleRequiredAttributes(isGiftRadioValue(event.target.value));
      });
    }
  })();
});
