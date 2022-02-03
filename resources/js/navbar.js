function handleMobileNavToggling() {
  const openBtn = document.querySelector('[data-mobile-nav-open-btn]');
  const closeBtn = document.querySelector('[data-mobile-nav-close-btn]');
  const nav = document.querySelector('[data-mobile-nav]');
  const body = document.querySelector('body');

  openBtn.addEventListener('click', () => {
    nav.classList.remove('hidden');
    body.classList.add('overflow-hidden');
  });

  closeBtn.addEventListener('click', () => {
    nav.classList.add('hidden');
    body.classList.remove('overflow-hidden');
  });
}

document.addEventListener('DOMContentLoaded', () => {
  handleMobileNavToggling();
});
