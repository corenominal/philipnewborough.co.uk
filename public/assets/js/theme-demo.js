// Theme demo: initialise Bootstrap components that are opt-in
(() => {
  const { bootstrap } = window;

  document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((element) => {
    bootstrap.Tooltip.getOrCreateInstance(element);
  });

  document.querySelectorAll('[data-bs-toggle="popover"]').forEach((element) => {
    bootstrap.Popover.getOrCreateInstance(element);
  });

  const toastTrigger = document.getElementById('demo-toast-trigger');
  const toast = document.getElementById('demo-toast');

  if (toastTrigger && toast) {
    toastTrigger.addEventListener('click', () => {
      bootstrap.Toast.getOrCreateInstance(toast).show();
    });
  }
})();
