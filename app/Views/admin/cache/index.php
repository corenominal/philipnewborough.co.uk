<?= $this->extend('templates/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="d-flex align-items-center justify-content-between border-bottom border-1 mb-4 pb-4 gap-3 flex-wrap">
                <h2 class="mb-0">Cache</h2>
                <?php if (! empty($files)): ?>
                <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmClearModal">
                    <i class="bi bi-trash3-fill me-1"></i> Clear All Cache
                </button>
                <?php endif; ?>
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

        </div>
    </div>

    <!-- Stats row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-sm-3">
            <div class="card bg-dark text-center py-3">
                <div class="fs-2 fw-bold text-white"><?= count($files) ?></div>
                <div class="text-secondary small">Total Files</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card bg-dark text-center py-3">
                <div class="fs-2 fw-bold text-success"><?= $activeCount ?></div>
                <div class="text-secondary small">Active</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card bg-dark text-center py-3">
                <div class="fs-2 fw-bold text-danger"><?= $expiredCount ?></div>
                <div class="text-secondary small">Expired</div>
            </div>
        </div>
        <div class="col-6 col-sm-3">
            <div class="card bg-dark text-center py-3">
                <div class="fs-2 fw-bold text-info"><?= $totalSize >= 1024 ? number_format($totalSize / 1024, 1) . ' KB' : $totalSize . ' B' ?></div>
                <div class="text-secondary small">Total Size</div>
            </div>
        </div>
    </div>

    <!-- Cache files table -->
    <div class="row">
        <div class="col-12">
            <div class="card bg-dark">
                <div class="card-header">
                    <h5 class="mb-0">Cache Files</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($files)): ?>
                    <p class="text-secondary fst-italic p-3 mb-0">No cache files found.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Filename</th>
                                    <th style="width: 5rem;">Size</th>
                                    <th style="width: 11rem;">Saved</th>
                                    <th style="width: 6rem;">TTL</th>
                                    <th style="width: 11rem;">Expires</th>
                                    <th style="width: 6rem;">Status</th>
                                    <th style="width: 5rem;">Type</th>
                                    <th style="width: 5rem;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($files as $i => $file): ?>
                                <tr>
                                    <!-- Filename / key -->
                                    <td>
                                        <?php if ($file['dataPreview'] !== null): ?>
                                        <button
                                            class="btn btn-link btn-sm text-start p-0 text-white font-monospace text-decoration-none"
                                            type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#preview-<?= $i ?>"
                                            aria-expanded="false"
                                            aria-controls="preview-<?= $i ?>"
                                            title="Toggle data preview"
                                        >
                                            <i class="bi bi-chevron-right me-1 text-secondary"></i><?= esc($file['filename']) ?>
                                        </button>
                                        <div class="collapse mt-2" id="preview-<?= $i ?>">
                                            <pre class="text-secondary small mb-0 p-2 border border-secondary rounded bg-black" style="max-height: 200px; overflow-y: auto; white-space: pre-wrap; word-break: break-all;"><?= esc($file['dataPreview']) ?></pre>
                                        </div>
                                        <?php else: ?>
                                        <span class="font-monospace text-secondary small"><?= esc($file['filename']) ?></span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Size -->
                                    <td class="text-secondary small text-nowrap">
                                        <?= $file['size'] >= 1024 ? number_format($file['size'] / 1024, 1) . ' KB' : $file['size'] . ' B' ?>
                                    </td>

                                    <!-- Saved time -->
                                    <td class="text-secondary small text-nowrap">
                                        <?php if ($file['saveTime'] !== null): ?>
                                        <span title="<?= esc(date('Y-m-d H:i:s', $file['saveTime'])) ?>"><?= esc(date('d M Y H:i:s', $file['saveTime'])) ?></span>
                                        <?php else: ?>
                                        <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- TTL -->
                                    <td class="text-secondary small text-nowrap">
                                        <?php if ($file['ttl'] === null): ?>
                                        <span class="text-muted">—</span>
                                        <?php elseif ($file['ttl'] === 0): ?>
                                        <span class="text-info">∞</span>
                                        <?php elseif ($file['ttl'] >= 3600): ?>
                                        <?= number_format($file['ttl'] / 3600, 1) ?> hr
                                        <?php elseif ($file['ttl'] >= 60): ?>
                                        <?= number_format($file['ttl'] / 60, 1) ?> min
                                        <?php else: ?>
                                        <?= $file['ttl'] ?> s
                                        <?php endif; ?>
                                    </td>

                                    <!-- Expires -->
                                    <td class="text-secondary small text-nowrap">
                                        <?php if ($file['expire'] === null && $file['ttl'] === 0): ?>
                                        <span class="text-info">Never</span>
                                        <?php elseif ($file['expire'] !== null): ?>
                                        <span title="<?= esc(date('Y-m-d H:i:s', $file['expire'])) ?>"><?= esc(date('d M Y H:i:s', $file['expire'])) ?></span>
                                        <?php else: ?>
                                        <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Status -->
                                    <td>
                                        <?php if ($file['status'] === 'active'): ?>
                                        <span class="badge text-bg-success">Active</span>
                                        <?php elseif ($file['status'] === 'expired'): ?>
                                        <span class="badge text-bg-danger">Expired</span>
                                        <?php elseif ($file['status'] === 'persistent'): ?>
                                        <span class="badge text-bg-info">Persistent</span>
                                        <?php else: ?>
                                        <span class="badge text-bg-secondary">Unknown</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Data type -->
                                    <td class="text-secondary small">
                                        <?= $file['dataType'] !== null ? esc(ucfirst($file['dataType'])) : '<span class="text-muted">—</span>' ?>
                                    </td>

                                    <!-- Delete action -->
                                    <td>
                                        <button
                                            type="button"
                                            class="btn btn-sm btn-outline-danger"
                                            title="Delete this cache file"
                                            data-bs-toggle="modal"
                                            data-bs-target="#confirmDeleteModal"
                                            data-filename="<?= esc($file['filename']) ?>"
                                        >
                                            <i class="bi bi-trash3"></i>
                                        </button>
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
    </div>

</div>

<!-- Confirm Delete Modal -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmDeleteModalLabel"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Delete Cache File</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary">
                Are you sure you want to delete <strong id="confirmDeleteFilename" class="text-white font-monospace"></strong>? This cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="/admin/cache/delete" method="post" id="confirmDeleteForm">
                    <?= csrf_field() ?>
                    <input type="hidden" name="filename" id="confirmDeleteInput" value="">
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3 me-1"></i> Delete
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    const modal = document.getElementById('confirmDeleteModal');
    modal.addEventListener('show.bs.modal', function (event) {
        const filename = event.relatedTarget.dataset.filename;
        modal.querySelector('#confirmDeleteFilename').textContent = filename;
        modal.querySelector('#confirmDeleteInput').value = filename;
    });
}());
</script>

<!-- Confirm Clear Modal -->
<div class="modal fade" id="confirmClearModal" tabindex="-1" aria-labelledby="confirmClearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content bg-dark">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmClearModalLabel"><i class="bi bi-exclamation-triangle-fill text-danger me-2"></i>Clear All Cache</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-secondary">
                Are you sure you want to delete all <?= count($files) ?> cache file(s)? This cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form action="/admin/cache/clear" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-trash3-fill me-1"></i> Clear All Cache
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
