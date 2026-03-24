'use strict';

// -- Sidebar active link -----------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#sidebar .nav-link').forEach((link) => {
        if (link.getAttribute('href') === '/admin/bio') {
            link.classList.remove('text-white-50');
            link.classList.add('active');
        }
    });
});
