function handleIsGiftToggle() {
    const gifteeForm = document.querySelector('.giftee-form');
    const radios = document.querySelectorAll('input[type="radio"][name="is_gift"]');

    const checkedRadio = document.querySelector('input[type="radio"][name="is_gift"]:checked');
    toggleGifteeForm(checkedRadio.value);

    for (let i = 0; i < radios.length; i++) {
        radios[i].addEventListener('change', function (event) {
            toggleGifteeForm(event.target.value);
        })
    }

    function toggleGifteeForm(radioValue) {
        const isGift = radioValue === 'yes';
        gifteeForm.style.display = isGift ? '' : 'none';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    handleIsGiftToggle();
});
