<?= $this->extend('templates/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">

            <div class="border-bottom border-1 mb-4 pb-4">
                <h2 class="mb-0">Bio</h2>
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

    <div class="row g-4">

        <!-- New bio form -->
        <div class="col-12 col-lg-5">
            <div class="card bg-dark border-secondary h-100">
                <div class="card-header border-secondary">
                    <h5 class="mb-0">Write New Bio</h5>
                </div>
                <div class="card-body">
                    <p class="text-secondary small">Saving a new bio will immediately make it the active bio shown on the home page.</p>
                    <form action="/admin/bio/store" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="bio" class="form-label fw-semibold">Bio</label>
                            <textarea
                                class="form-control<?= session()->getFlashdata('error') ? ' is-invalid' : '' ?>"
                                id="bio"
                                name="bio"
                                rows="6"
                                placeholder="Write your bio here…"
                                required
                                autofocus
                            ><?= esc(old('bio')) ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-floppy-fill me-1"></i> Save &amp; Activate
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Bio history -->
        <div class="col-12 col-lg-7">
            <div class="card bg-dark border-secondary h-100">
                <div class="card-header border-secondary">
                    <h5 class="mb-0">Bio History</h5>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($bios)): ?>
                    <p class="text-secondary fst-italic p-3">No bios saved yet.</p>
                    <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Bio</th>
                                    <th style="width: 7rem;">Saved</th>
                                    <th style="width: 6rem;">Status</th>
                                    <th style="width: 5rem;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bios as $row): ?>
                                <tr>
                                    <td class="text-secondary small"><?= esc($row['bio']) ?></td>
                                    <td class="text-secondary small text-nowrap"><?= esc(date('d M Y', strtotime($row['created_at']))) ?></td>
                                    <td>
                                        <?php if ($row['is_active']): ?>
                                        <span class="badge text-bg-success">Active</span>
                                        <?php else: ?>
                                        <span class="badge text-bg-secondary">Inactive</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if (! $row['is_active']): ?>
                                        <form action="/admin/bio/activate/<?= esc($row['id']) ?>" method="post">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-sm btn-outline-primary" title="Activate this bio">
                                                <i class="bi bi-check2-circle"></i>
                                            </button>
                                        </form>
                                        <?php else: ?>
                                        <span class="text-secondary">—</span>
                                        <?php endif; ?>
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
<?= $this->endSection() ?>
