document.addEventListener('DOMContentLoaded', () => {
  (function handleToggling() {
    const triggers = document.querySelectorAll<HTMLElement>('[data-expandable-trigger]');

    for (let i = 0; i < triggers.length; i += 1) {
      triggers[i].addEventListener('click', () => {
        const content = triggers[i].nextElementSibling as HTMLElement | null;
        if (!content) {
          throw new Error('Could not find expandable content.');
        }

        const icon = triggers[i].querySelector('svg');
        if (!icon) {
          throw new Error('Could not find expandable content SVG icon.');
        }

        const isOpen = content.getAttribute('data-expandable-content-state') === 'open';

        if (isOpen) {
          content.style.maxHeight = '0px';
          content.setAttribute('data-expandable-content-state', 'closed');
          icon.setAttribute('data-icon', 'plus');
        } else {
          content.style.maxHeight = `${content.scrollHeight}px`;
          content.setAttribute('data-expandable-content-state', 'open');
          icon.setAttribute('data-icon', 'minus');
        }
      });
    }
  })();
});
