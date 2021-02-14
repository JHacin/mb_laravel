document.addEventListener('DOMContentLoaded', () => {
    const burger = document.querySelector('.navbar-burger');

    if (burger) {
        burger.addEventListener('click', () => {
            burger.classList.toggle('is-active');

            const target = document.getElementById(burger.dataset.target);
            target.classList.toggle('is-active');
        });
    }
});
