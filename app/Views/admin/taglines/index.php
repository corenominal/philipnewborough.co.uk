<?= $this->extend('templates/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="border-bottom border-1 mb-4 pb-4 d-flex align-items-center justify-content-between gap-3">
                <h2 class="mb-0">Taglines</h2>
                <div role="group" aria-label="Page actions">
                    <a href="/admin/taglines/create" class="btn btn-outline-primary">
                        <i class="bi bi-plus-circle-fill"></i><span class="d-none d-lg-inline"> Add Tagline</span>
                    </a>
                    <button type="button" class="btn btn-outline-danger" id="btn-delete" disabled>
                        <i class="bi bi-trash3-fill"></i><span class="d-none d-lg-inline"> Delete</span>
                    </button>
                </div>
            </div>

            <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <p class="text-secondary">
                Manage the taglines that rotate on the home page hero section. Use the arrows to reorder them, and toggle the switch to show or hide individual taglines.
            </p>

            <?php if (empty($taglines)): ?>
            <p class="text-secondary fst-italic">No taglines found. <a href="/admin/taglines/create">Add one</a>.</p>
            <?php else: ?>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle" id="taglines-table">
                    <thead>
                        <tr>
                            <th style="width: 2.5rem;">
                                <input type="checkbox" id="select-all-checkbox" class="form-check-input" aria-label="Select all">
                            </th>
                            <th>Tagline</th>
                            <th style="width: 8rem;">Status</th>
                            <th style="width: 7rem;">Order</th>
                            <th style="width: 6rem;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($taglines as $row): ?>
                        <tr data-id="<?= esc($row['id']) ?>">
                            <td>
                                <input type="checkbox" class="row-select form-check-input" value="<?= esc($row['id']) ?>" aria-label="Select row">
                            </td>
                            <td class="tagline-text"><?= esc($row['tagline']) ?></td>
                            <td>
                                <div class="form-check form-switch mb-0">
                                    <input
                                        class="form-check-input toggle-active"
                                        type="checkbox"
                                        role="switch"
                                        data-id="<?= esc($row['id']) ?>"
                                        <?= $row['is_active'] ? 'checked' : '' ?>
                                        aria-label="Toggle active"
                                    >
                                    <label class="form-check-label toggle-label text-<?= $row['is_active'] ? 'success' : 'secondary' ?>">
                                        <?= $row['is_active'] ? 'Active' : 'Inactive' ?>
                                    </label>
                                </div>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-move-up" data-id="<?= esc($row['id']) ?>" aria-label="Move up">
                                    <i class="bi bi-arrow-up"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary btn-move-down" data-id="<?= esc($row['id']) ?>" aria-label="Move down">
                                    <i class="bi bi-arrow-down"></i>
                                </button>
                            </td>
                            <td>
                                <a href="/admin/taglines/edit/<?= esc($row['id']) ?>" class="btn btn-sm btn-outline-primary" aria-label="Edit">
                                    <i class="bi bi-pencil-fill"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<!-- Delete confirmation modal -->
<div class="modal fade" id="modal-delete-confirm" tabindex="-1" aria-labelledby="modal-delete-confirm-label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-delete-confirm-label">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <strong id="delete-modal-count">0</strong> selected tagline(s)? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="btn-delete-confirm">Delete</button>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
