function getForm() {
    return document.querySelector('.giftee-form');
}

function toggleFormVisibility(isGift) {
    getForm().style.display = isGift ? '' : 'none';
}

function toggleRequiredAttributes(isGift) {
    const fields = getForm().querySelectorAll('input, select');

    for (let i = 0; i < fields.length; i += 1) {
        fields[i].required = isGift;
    }
}

function isGiftRadioValue(radioValue) {
    return radioValue === 'yes';
}

function setDefaultFormAttributes() {
    const checkedRadio = document.querySelector('input[type="radio"][name="is_gift"]:checked');

    toggleFormVisibility(isGiftRadioValue(checkedRadio.value));
    toggleRequiredAttributes(isGiftRadioValue(checkedRadio.value));
}

function handleToggling() {
    const radios = document.querySelectorAll('input[type="radio"][name="is_gift"]');

    for (let i = 0; i < radios.length; i += 1) {
        radios[i].addEventListener('change', (event) => {
            toggleFormVisibility(isGiftRadioValue(event.target.value));
            toggleRequiredAttributes(isGiftRadioValue(event.target.value));
        });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    setDefaultFormAttributes();
    handleToggling();
});
