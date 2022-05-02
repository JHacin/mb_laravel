document.addEventListener('DOMContentLoaded', () => {
  (function closeNotificationsOnClick() {
    (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
      const $notification = $delete.parentNode as HTMLElement;

      $delete.addEventListener('click', () => {
        $notification.parentNode!.removeChild($notification);
      });
    });
  })();
});
