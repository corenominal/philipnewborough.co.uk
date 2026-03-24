<?= $this->extend('templates/dashboard') ?>

<?= $this->section('content') ?>
<div class="container-fluid">

    <!-- Page heading -->
    <div class="border-bottom border-1 mb-4 pb-4">
        <h2 class="mb-0">Dashboard</h2>
    </div>

    <!-- Stats row -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg-3">
            <a href="/admin/taglines" class="text-decoration-none">
                <div class="card bg-dark text-center py-3 px-2 h-100 stat-card">
                    <div class="d-flex justify-content-center">
                        <span class="stat-card__icon stat-card__icon--taglines"><i class="bi bi-chat-quote-fill"></i></span>
                    </div>
                    <div class="fs-2 fw-bold text-white"><?= $taglineActive ?><span class="fs-6 text-secondary fw-normal"> / <?= $taglineTotal ?></span></div>
                    <div class="text-secondary small">Taglines Active</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="/admin/bio" class="text-decoration-none">
                <div class="card bg-dark text-center py-3 px-2 h-100 stat-card">
                    <div class="d-flex justify-content-center">
                        <span class="stat-card__icon stat-card__icon--bio"><i class="bi bi-person-lines-fill"></i></span>
                    </div>
                    <div class="fs-2 fw-bold text-white"><?= $bioCount ?></div>
                    <div class="text-secondary small">Bio Versions</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="/admin/github-activity" class="text-decoration-none">
                <div class="card bg-dark text-center py-3 px-2 h-100 stat-card">
                    <div class="d-flex justify-content-center">
                        <span class="stat-card__icon stat-card__icon--activity"><i class="bi bi-activity"></i></span>
                    </div>
                    <div class="fs-2 fw-bold text-white"><?= $activityTotal ?></div>
                    <div class="text-secondary small">GitHub Events</div>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a href="/admin/cache" class="text-decoration-none">
                <div class="card bg-dark text-center py-3 px-2 h-100 stat-card">
                    <div class="d-flex justify-content-center">
                        <span class="stat-card__icon stat-card__icon--cache"><i class="bi bi-database"></i></span>
                    </div>
                    <div class="fs-2 fw-bold text-white"><?= $cacheCount ?></div>
                    <div class="text-secondary small">Cache Files</div>
                </div>
            </a>
        </div>
    </div>

    <!-- Main content row -->
    <div class="row g-4">

        <!-- Recent GitHub Activity -->
        <div class="col-lg-8">
            <div class="card bg-dark h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-activity me-2"></i>Recent GitHub Activity</span>
                    <a href="/admin/github-activity" class="btn btn-sm btn-outline-secondary">View all</a>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($recentActivity)): ?>
                    <p class="text-secondary p-3 mb-0">No GitHub activity recorded yet.</p>
                    <?php else: ?>
                    <ul class="list-group list-group-flush">
                        <?php foreach ($recentActivity as $event): ?>
                        <li class="list-group-item bg-dark d-flex align-items-start gap-3 py-3">
                            <span class="badge <?= esc($event['label_class'] ?? 'text-bg-secondary') ?> mt-1 text-nowrap"><?= esc($event['label'] ?? $event['type']) ?></span>
                            <div class="flex-grow-1 overflow-hidden">
                                <?php if (!empty($event['link'])): ?>
                                <a href="<?= esc($event['link']) ?>" target="_blank" rel="noopener noreferrer" class="text-white text-decoration-none text-truncate d-block small fw-semibold"><?= esc($event['repo']) ?></a>
                                <?php else: ?>
                                <span class="text-white text-truncate d-block small fw-semibold"><?= esc($event['repo']) ?></span>
                                <?php endif; ?>
                                <span class="text-secondary" style="font-size:.8rem"><?= esc($event['description'] ?? '') ?></span>
                            </div>
                            <span class="text-secondary text-nowrap" style="font-size:.75rem"><?= esc($event['time_ago'] ?? '') ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right column -->
        <div class="col-lg-4 d-flex flex-column gap-4">

            <!-- Active Bio -->
            <div class="card bg-dark">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-person-lines-fill me-2"></i>Active Bio</span>
                    <a href="/admin/bio" class="btn btn-sm btn-outline-secondary">Manage</a>
                </div>
                <div class="card-body">
                    <?php if (!empty($activeBio['bio'])): ?>
                    <p class="text-secondary small mb-0"><?= nl2br(esc(mb_substr($activeBio['bio'], 0, 300) . (mb_strlen($activeBio['bio']) > 300 ? '…' : ''))) ?></p>
                    <?php else: ?>
                    <p class="text-secondary small mb-0">No active bio set.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Quick links -->
            <div class="card bg-dark">
                <div class="card-header"><i class="bi bi-lightning-fill me-2"></i>Quick Links</div>
                <div class="list-group list-group-flush">
                    <a href="/admin/taglines/create" class="list-group-item list-group-item-action bg-dark text-white-50">
                        <i class="bi bi-plus-circle me-2"></i> New Tagline
                    </a>
                    <a href="/admin/bio" class="list-group-item list-group-item-action bg-dark text-white-50">
                        <i class="bi bi-pencil-square me-2"></i> Write New Bio
                    </a>
                    <a href="/admin/cache" class="list-group-item list-group-item-action bg-dark text-white-50">
                        <i class="bi bi-database me-2"></i> Manage Cache
                    </a>
                    <a href="/admin/github-activity" class="list-group-item list-group-item-action bg-dark text-white-50">
                        <i class="bi bi-github me-2"></i> GitHub Activity
                    </a>
                </div>
            </div>

        </div>
    </div>

</div>
<?= $this->endSection() ?>
