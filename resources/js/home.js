function handleStickyNav() {
    let didScroll;

    const header = document.querySelector('.home-header');
    const html = document.querySelector('html');

    function adjustNavPosition() {
        const headerHeight = header.offsetHeight;
        const verticalScrollOffset = window.pageYOffset;

        if (verticalScrollOffset >= headerHeight) {
            html.classList.remove('is-homepage');
        } else {
            html.classList.add('is-homepage');
        }
    }

    window.addEventListener('scroll', () => {
        didScroll = true;
    });

    setInterval(() => {
        if (didScroll) {
            adjustNavPosition();
            didScroll = false;
        }
    }, 50);
}

document.addEventListener('DOMContentLoaded', () => {
    handleStickyNav();
});
