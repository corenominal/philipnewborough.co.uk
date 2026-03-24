'use strict';

// -- Sidebar active link -----------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#sidebar .nav-link').forEach((link) => {
        if (link.getAttribute('href') === '/admin/cache') {
            link.classList.remove('text-white-50');
            link.classList.add('active');
        }
    });
});
