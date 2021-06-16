document.addEventListener('DOMContentLoaded', () => {
    setDefaultFormAttributes();
    handleIsGiftToggle();
});

function setDefaultFormAttributes() {
    const checkedRadio = document.querySelector('input[type="radio"][name="is_gift"]:checked');

    toggleGifteeFormVisibility(isGift(checkedRadio.value));
    toggleGifteeFormRequiredAttributes(isGift(checkedRadio.value));
}

function handleIsGiftToggle() {
    const radios = document.querySelectorAll('input[type="radio"][name="is_gift"]');

    for (let i = 0; i < radios.length; i++) {
        radios[i].addEventListener('change', function (event) {
            toggleGifteeFormVisibility(isGift(event.target.value));
            toggleGifteeFormRequiredAttributes(isGift(event.target.value));
        })
    }
}

function toggleGifteeFormVisibility(isGift) {
    getGifteeForm().style.display = isGift ? '' : 'none';
}


function toggleGifteeFormRequiredAttributes(isGift) {
    const fields = getGifteeForm().querySelectorAll('input, select');

    for (let i = 0; i < fields.length; i++) {
        fields[i].required = isGift;
    }
}

function getGifteeForm() {
    return document.querySelector('.giftee-form')
}

function isGift(radioValue) {
    return radioValue === 'yes';
}

