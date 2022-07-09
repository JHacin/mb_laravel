document.addEventListener('DOMContentLoaded', () => {
  (function initSpecialSponsorshipCardDetailsListeners() {
    const cards = document.querySelectorAll('[data-ss-card]');

    for (let i = 0; i < cards.length; i++) {
      const card = cards[i];
      const trigger = card.querySelector('[data-ss-card-details-trigger]') as HTMLElement;
      const details = card.querySelector('[data-ss-card-details]') as HTMLElement
      const closeBtn = card.querySelector('[data-ss-card-details-close]') as HTMLElement

      trigger.addEventListener('click', () => {
        details.classList.remove('-translate-x-full')
      });

      closeBtn.addEventListener('click', () => {
        details.classList.add('-translate-x-full')
      });
    }
  })();
});
