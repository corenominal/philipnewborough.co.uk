'use strict';

// -- Sidebar active link -----------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('#sidebar .nav-link').forEach((link) => {
        if (link.getAttribute('href') === '/admin/github-activity') {
            link.classList.remove('text-white-50');
            link.classList.add('active');
        }
    });
});

// -- DataTable ---------------------------------------------------------------

document.addEventListener('DOMContentLoaded', () => {
    const selectedIds = new Set();

    function updateDeleteButton() {
        const btn = document.getElementById('btn-delete');
        if (btn) btn.disabled = selectedIds.size === 0;
    }

    const githubActivityTable = new DataTable('#github-activity-table', {

        // ── Layout & UI ────────────────────────────────────────────────────────
        autoWidth:    true,
        info:         true,
        lengthChange: true,
        ordering:     true,
        paging:       true,
        searching:    true,
        orderMulti:   true,
        orderClasses: true,
        pagingType:   'simple_numbers',
        pageLength:   25,
        lengthMenu:   [10, 25, 50, 100],

        // ── Default sort ───────────────────────────────────────────────────────
        order: [[6, 'desc']],

        // ── Performance ────────────────────────────────────────────────────────
        deferRender: false,
        processing:  true,
        serverSide:  true,
        stateSave:   false,

        // ── Data source ────────────────────────────────────────────────────────
        ajax: {
            url: '/admin/github-activity/datatable',
        },

        // ── Column definitions ─────────────────────────────────────────────────
        columns: [
            {
                // Column 0 — Checkbox (row select)
                data:           null,
                title:          '<input type="checkbox" id="select-all-checkbox" class="form-check-input" aria-label="Select all rows on this page">',
                orderable:      false,
                searchable:     false,
                visible:        true,
                width:          '2rem',
                className:      'text-center',
                defaultContent: '<input type="checkbox" class="row-select form-check-input" aria-label="Select row">',
            },
            {
                // Column 1 — #
                name:       'id',
                data:       'id',
                title:      '#',
                type:       'num',
                orderable:  true,
                searchable: false,
                visible:    true,
                width:      '3rem',
                className:  'text-end',
            },
            {
                // Column 2 — Label (server returns badge HTML)
                name:       'label',
                data:       'label',
                title:      'Label',
                type:       'string',
                orderable:  true,
                searchable: true,
                visible:    true,
                width:      '7rem',
                className:  'text-center',
            },
            {
                // Column 3 — Type
                name:       'type',
                data:       'type',
                title:      'Type',
                type:       'string',
                orderable:  true,
                searchable: true,
                visible:    true,
                width:      '10rem',
                className:  '',
            },
            {
                // Column 4 — Repo (server returns HTML link when a link is present)
                name:       'repo',
                data:       'repo',
                title:      'Repo',
                type:       'string',
                orderable:  true,
                searchable: true,
                visible:    true,
                width:      '',
                className:  '',
            },
            {
                // Column 5 — Description
                name:       'description',
                data:       'description',
                title:      'Description',
                type:       'string',
                orderable:  false,
                searchable: true,
                visible:    true,
                width:      '',
                className:  '',
            },
            {
                // Column 6 — Date
                name:       'github_created_at',
                data:       'github_created_at',
                title:      'Date',
                type:       'date',
                orderable:  true,
                searchable: false,
                visible:    true,
                width:      '10rem',
                className:  '',
            },
        ],

        // ── Language / localisation ────────────────────────────────────────────
        language: {
            emptyTable:     'No activity records found',
            info:           'Showing _START_ to _END_ of _TOTAL_ entries',
            infoEmpty:      'Showing 0 to 0 of 0 entries',
            infoFiltered:   '(filtered from _MAX_ total entries)',
            lengthMenu:     'Show _MENU_ entries',
            loadingRecords: 'Loading...',
            processing:     'Processing...',
            search:         'Search:',
            zeroRecords:    'No matching records found',
            paginate: {
                first:    'First',
                last:     'Last',
                next:     'Next',
                previous: 'Previous',
            },
        },

        // ── Callbacks ──────────────────────────────────────────────────────────
        drawCallback: function () {
            // Restore checkbox state and row highlight after each draw
            githubActivityTable.rows({ page: 'current' }).every(function () {
                const id       = this.data().id;
                const checkbox = this.node().querySelector('.row-select');
                const selected = selectedIds.has(id);
                if (checkbox) checkbox.checked = selected;
                this.node().classList.toggle('table-active', selected);
            });
            // Sync the select-all header checkbox
            const selectAll = document.getElementById('select-all-checkbox');
            if (selectAll) {
                const visibleIds = [];
                githubActivityTable.rows({ page: 'current' }).every(function () { visibleIds.push(this.data().id); });
                const n = visibleIds.filter((id) => selectedIds.has(id)).length;
                selectAll.checked       = n > 0 && n === visibleIds.length;
                selectAll.indeterminate = n > 0 && n < visibleIds.length;
            }
            updateDeleteButton();
        },
    });

    // ── Row checkbox clicks ────────────────────────────────────────────────────
    document.querySelector('#github-activity-table tbody').addEventListener('change', (e) => {
        if (!e.target.classList.contains('row-select')) return;
        const row = githubActivityTable.row(e.target.closest('tr'));
        const id  = row.data().id;
        const tr  = e.target.closest('tr');
        if (e.target.checked) {
            selectedIds.add(id);
            tr.classList.add('table-active');
        } else {
            selectedIds.delete(id);
            tr.classList.remove('table-active');
        }
        const selectAll = document.getElementById('select-all-checkbox');
        if (selectAll) {
            const visibleIds = [];
            githubActivityTable.rows({ page: 'current' }).every(function () { visibleIds.push(this.data().id); });
            const n = visibleIds.filter((id) => selectedIds.has(id)).length;
            selectAll.checked       = n > 0 && n === visibleIds.length;
            selectAll.indeterminate = n > 0 && n < visibleIds.length;
        }
        updateDeleteButton();
    });

    // ── Select-all checkbox (current page) ────────────────────────────────────
    document.querySelector('#github-activity-table thead').addEventListener('change', (e) => {
        if (e.target.id !== 'select-all-checkbox') return;
        githubActivityTable.rows({ page: 'current' }).every(function () {
            const id       = this.data().id;
            const checkbox = this.node().querySelector('.row-select');
            if (e.target.checked) {
                selectedIds.add(id);
                if (checkbox) checkbox.checked = true;
                this.node().classList.add('table-active');
            } else {
                selectedIds.delete(id);
                if (checkbox) checkbox.checked = false;
                this.node().classList.remove('table-active');
            }
        });
        updateDeleteButton();
    });

    // ── Refresh button ─────────────────────────────────────────────────────────
    document.getElementById('btn-datatable-refresh').addEventListener('click', () => {
        githubActivityTable.ajax.reload(null, false);
    });

    // ── Delete button → show confirmation modal ────────────────────────────────
    const deleteModalEl = document.getElementById('modal-delete-confirm');
    const deleteModal   = new bootstrap.Modal(deleteModalEl, { focus: false });

    deleteModalEl.addEventListener('shown.bs.modal', () => {
        const closeBtn = deleteModalEl.querySelector('.btn-close');
        if (closeBtn) closeBtn.focus();
    });

    deleteModalEl.addEventListener('hide.bs.modal', () => {
        const focused = deleteModalEl.querySelector(':focus');
        if (focused) focused.blur();
        const btn = document.getElementById('btn-delete');
        if (btn && !btn.disabled) btn.focus();
    });

    document.getElementById('btn-delete').addEventListener('click', () => {
        document.getElementById('delete-modal-count').textContent = selectedIds.size;
        deleteModal.show();
    });

    // ── Confirm delete ─────────────────────────────────────────────────────────
    document.getElementById('btn-delete-confirm').addEventListener('click', () => {
        const ids = Array.from(selectedIds);

        fetch('/admin/github-activity/delete', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body:    JSON.stringify({ ids }),
        })
            .then((res) => res.json())
            .then(() => {
                deleteModal.hide();
                selectedIds.clear();
                updateDeleteButton();
                githubActivityTable.ajax.reload(null, false);
            })
            .catch((err) => console.error('Delete failed:', err));
    });
});
