'use strict';

// -- Sidebar active link -----------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#sidebar .nav-link').forEach((link) => {
        if (link.getAttribute('href') === '/admin/taglines') {
            link.classList.remove('text-white-50');
            link.classList.add('active');
        }
    });
});

// -- Selection state ---------------------------------------------------------

const selectedIds = new Set();

function updateDeleteButton() {
    const btn = document.getElementById('btn-delete');
    if (btn) btn.disabled = selectedIds.size === 0;
}

document.addEventListener('DOMContentLoaded', () => {

    // Select-all checkbox
    const selectAll = document.getElementById('select-all-checkbox');
    if (selectAll) {
        selectAll.addEventListener('change', () => {
            document.querySelectorAll('.row-select').forEach((cb) => {
                cb.checked = selectAll.checked;
                const id = parseInt(cb.value, 10);
                if (selectAll.checked) {
                    selectedIds.add(id);
                } else {
                    selectedIds.delete(id);
                }
            });
            updateDeleteButton();
        });
    }

    // Individual row checkboxes
    document.querySelectorAll('.row-select').forEach((cb) => {
        cb.addEventListener('change', () => {
            const id = parseInt(cb.value, 10);
            if (cb.checked) {
                selectedIds.add(id);
            } else {
                selectedIds.delete(id);
            }
            updateDeleteButton();
        });
    });

    // -- Delete flow ---------------------------------------------------------

    const deleteBtn        = document.getElementById('btn-delete');
    const deleteCountEl    = document.getElementById('delete-modal-count');
    const deleteConfirmBtn = document.getElementById('btn-delete-confirm');
    const deleteModal      = document.getElementById('modal-delete-confirm')
        ? bootstrap.Modal.getOrCreateInstance(document.getElementById('modal-delete-confirm'))
        : null;

    if (deleteBtn) {
        deleteBtn.addEventListener('click', () => {
            if (deleteCountEl) deleteCountEl.textContent = selectedIds.size;
            if (deleteModal) deleteModal.show();
        });
    }

    if (deleteConfirmBtn) {
        deleteConfirmBtn.addEventListener('click', async () => {
            if (deleteModal) deleteModal.hide();

            try {
                const response = await fetch('/admin/taglines/delete', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify({ ids: Array.from(selectedIds) }),
                });

                if (!response.ok) throw new Error('Request failed');

                selectedIds.forEach((id) => {
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) row.remove();
                });
                selectedIds.clear();
                updateDeleteButton();
            } catch (err) {
                alert('Failed to delete tagline(s). Please try again.');
            }
        });
    }

    // -- Move up / down ------------------------------------------------------

    document.querySelectorAll('.btn-move-up').forEach((btn) => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            await reorder(id, 'up');
        });
    });

    document.querySelectorAll('.btn-move-down').forEach((btn) => {
        btn.addEventListener('click', async () => {
            const id = btn.dataset.id;
            await reorder(id, 'down');
        });
    });

    async function reorder(id, direction) {
        try {
            const response = await fetch(`/admin/taglines/move-${direction}/${id}`, {
                method: 'POST',
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            });

            const data = await response.json();

            if (data.status === 'success') {
                // Reload the page to reflect the new order
                window.location.reload();
            }
        } catch (err) {
            alert('Failed to reorder. Please try again.');
        }
    }

    // -- Toggle active -------------------------------------------------------

    document.querySelectorAll('.toggle-active').forEach((toggle) => {
        toggle.addEventListener('change', async () => {
            const id    = toggle.dataset.id;
            const label = toggle.closest('.form-check').querySelector('.toggle-label');

            try {
                const response = await fetch(`/admin/taglines/toggle/${id}`, {
                    method: 'POST',
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                });

                const data = await response.json();

                if (data.status === 'success') {
                    if (label) {
                        label.textContent = data.is_active ? 'Active' : 'Inactive';
                        label.className   = `form-check-label toggle-label text-${data.is_active ? 'success' : 'secondary'}`;
                    }
                } else {
                    // Revert the toggle if the request failed
                    toggle.checked = !toggle.checked;
                    alert('Failed to update status. Please try again.');
                }
            } catch (err) {
                toggle.checked = !toggle.checked;
                alert('Failed to update status. Please try again.');
            }
        });
    });

});
