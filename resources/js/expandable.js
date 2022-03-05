function handleToggling() {
  const triggers = document.querySelectorAll('[data-expandable-trigger]');

  for (let i = 0; i < triggers.length; i += 1) {
    triggers[i].addEventListener('click', () => {
      const content = triggers[i].nextElementSibling;
      const icon = triggers[i].querySelector('svg');

      const isOpen = content.getAttribute('data-expandable-content-state') === 'open';

      if (isOpen) {
        content.style.maxHeight = '0px';
        content.setAttribute('data-expandable-content-state', 'closed');
        icon.setAttribute('data-icon', 'plus')
      } else {
        content.style.maxHeight = `${content.scrollHeight}px`;
        content.setAttribute('data-expandable-content-state', 'open');
        icon.setAttribute('data-icon', 'minus')
      }
    });
  }
}

document.addEventListener('DOMContentLoaded', () => {
  handleToggling();
});