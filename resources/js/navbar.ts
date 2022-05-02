document.addEventListener('DOMContentLoaded', () => {
  (function handleMobileNavToggling() {
    const openBtn = document.querySelector('[data-mobile-nav-open-btn]');
    const closeBtn = document.querySelector('[data-mobile-nav-close-btn]');
    const nav = document.querySelector('[data-mobile-nav]') as HTMLElement;
    const body = document.querySelector('body') as HTMLElement;

    if (openBtn) {
      openBtn.addEventListener('click', () => {
        nav.classList.remove('hidden');
        body.classList.add('overflow-hidden');
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', () => {
        nav.classList.add('hidden');
        body.classList.remove('overflow-hidden');
      });
    }
  })();
});
