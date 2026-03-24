<?= $this->extend('templates/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">

            <div class="border-bottom border-1 mb-4 pb-4 d-flex align-items-center justify-content-between gap-3">
                <h2 class="mb-0"><?= esc($title) ?></h2>
                <a href="/admin/taglines" class="btn btn-outline-secondary">
                    <i class="bi bi-arrow-left"></i><span class="d-none d-lg-inline"> Back</span>
                </a>
            </div>

            <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php endif; ?>

            <?php
                $isEdit    = isset($tagline) && $tagline !== null;
                $actionUrl = $isEdit ? '/admin/taglines/update/' . esc($tagline['id']) : '/admin/taglines/store';
            ?>

            <form action="<?= $actionUrl ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="tagline" class="form-label fw-semibold">Tagline</label>
                    <input
                        type="text"
                        class="form-control<?= session()->getFlashdata('error') ? ' is-invalid' : '' ?>"
                        id="tagline"
                        name="tagline"
                        maxlength="255"
                        value="<?= esc(old('tagline', $isEdit ? $tagline['tagline'] : '')) ?>"
                        placeholder="e.g. Web Developer"
                        required
                        autofocus
                    >
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy-fill me-1"></i> <?= $isEdit ? 'Save Changes' : 'Add Tagline' ?>
                    </button>
                    <a href="/admin/taglines" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>

        </div>
    </div>
</div>
<?= $this->endSection() ?>
