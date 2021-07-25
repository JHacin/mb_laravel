document.addEventListener('DOMContentLoaded', () => {
    setDefaultFormAttributes();
    handleToggling();
});

function setDefaultFormAttributes() {
    const checkedRadio = document.querySelector('input[type="radio"][name="is_gift"]:checked');

    toggleFormVisibility(isGift(checkedRadio.value));
    toggleRequiredAttributes(isGift(checkedRadio.value));
}

function handleToggling() {
    const radios = document.querySelectorAll('input[type="radio"][name="is_gift"]');

    for (let i = 0; i < radios.length; i++) {
        radios[i].addEventListener('change', function (event) {
            toggleFormVisibility(isGift(event.target.value));
            toggleRequiredAttributes(isGift(event.target.value));
        })
    }
}

function toggleFormVisibility(isGift) {
    getForm().style.display = isGift ? '' : 'none';
}


function toggleRequiredAttributes(isGift) {
    const fields = getForm().querySelectorAll('input, select');

    for (let i = 0; i < fields.length; i++) {
        fields[i].required = isGift;
    }
}

function getForm() {
    return document.querySelector('.giftee-form')
}

function isGift(radioValue) {
    return radioValue === 'yes';
}

