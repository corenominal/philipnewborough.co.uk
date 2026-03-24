<?= $this->extend('templates/default') ?>

<?= $this->section('content') ?>

<?php
    $githubUsername = (string) config('GitHub')->username;
    $blogUrl        = rtrim((string) config('Urls')->blog, '/');
    $statusUrl      = rtrim((string) config('Urls')->status, '/');
    $bookmarksUrl   = rtrim((string) config('Urls')->bookmarks, '/');
    $githubUrl      = 'https://github.com/' . rawurlencode($githubUsername);
?>

<!-- ============================================================
     HERO
     ============================================================ -->
<section class="home-hero mx-n2 mt-n3 mb-0">
    <div class="home-hero__network"><canvas id="home-network-canvas" aria-hidden="true"></canvas></div>
    <div class="home-hero__content container px-4 py-5">
        <div class="row align-items-center justify-content-center g-4 py-lg-3">

            <div class="col-lg-7 text-center text-lg-start">
                <p class="home-hero__greeting text-primary mb-2 fw-semibold font-monospace small">
                    <i class="bi bi-terminal-fill me-1"></i> $ whoami
                </p>
                <h1 class="home-hero__name display-3 fw-bold mb-3">
                    Philip Newborough
                </h1>
                <p class="home-hero__tagline fs-4 mb-4">
                    <span class="text-primary opacity-75">&gt;</span>
                    <span id="hero-tagline" class="tagline-text ms-1"
                          data-taglines="<?= esc(json_encode(array_column($taglines ?? [], 'tagline'))) ?>">Web Developer</span><span class="tagline-cursor">▍</span>
                </p>
                <?php if ($bio): ?>
                <p class="home-hero__bio lead text-secondary mb-4">
                    <?= esc($bio) ?>
                </p>
                <?php endif; ?>
                <div class="home-hero__links d-flex flex-wrap gap-2 justify-content-center justify-content-lg-start">
                    
                    <?php if ($blogUrl): ?>
                    <a href="<?= esc($blogUrl) ?>" class="btn btn-outline-primary" rel="noopener noreferrer">
                        <i class="bi bi-rss-fill me-1"></i> Blog
                    </a>
                    <?php endif; ?>
                    <?php if ($statusUrl): ?>
                    <a href="<?= esc($statusUrl) ?>" class="btn btn-outline-primary" rel="noopener noreferrer">
                        <i class="bi bi-chat-square-dots-fill me-1"></i> Status
                    </a>
                    <?php endif; ?>
                    <?php if ($bookmarksUrl): ?>
                    <a href="<?= esc($bookmarksUrl) ?>" class="btn btn-outline-primary" rel="noopener noreferrer">
                        <i class="bi bi-bookmarks-fill me-1"></i> Bookmarks
                    </a>
                    <?php endif; ?>
                    <?php if ($githubUrl): ?>
                    <a href="<?= esc($githubUrl) ?>" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-github me-1"></i> GitHub
                    </a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-lg-4 d-none d-lg-flex justify-content-center">
                <div class="home-hero__avatar">
                    <?php if ($githubUsername): ?>
                    <img src="https://github.com/<?= rawurlencode($githubUsername) ?>.png?size=200"
                         alt="<?= esc($githubUsername) ?>"
                         class="home-hero__avatar-img rounded-circle"
                         loading="lazy">
                    <?php else: ?>
                    <i class="bi bi-person-circle home-hero__avatar-icon"></i>
                    <?php endif; ?>
                    <div class="home-hero__avatar-ring"></div>
                </div>
            </div>

        </div>
    </div>
</section>

<script defer src="/assets/js/home-hero-network.js"></script>

<!-- ============================================================
     GITHUB ACTIVITY
     ============================================================ -->
<?php if (! empty($github_events)): ?>
<section class="container px-4 my-5 animate-on-scroll">
    <div class="home-section-label">
        <i class="bi bi-github me-1"></i> Recent Activity
    </div>
    <div class="terminal-window">
        <div class="terminal-header">
            <span class="terminal-dot terminal-dot--close"></span>
            <span class="terminal-dot terminal-dot--minimize"></span>
            <span class="terminal-dot terminal-dot--maximize"></span>
            <span class="terminal-header__title font-monospace text-secondary ms-3 small">
                corenominal@github — git log --oneline
                <span class="text-muted">(<?= count($github_events) ?> events)</span>
            </span>
        </div>
        <div class="terminal-body">
            <?php foreach ($github_events as $event): ?>
            <a href="<?= esc($event['link']) ?>"
               class="terminal-row card-animate d-flex align-items-center gap-2 gap-sm-3 text-decoration-none"
               target="_blank"
               rel="noopener noreferrer">
                <span class="terminal-row__time font-monospace text-muted d-none d-sm-block"><?= esc($event['time_ago']) ?></span>
                <span class="badge bg-<?= esc($event['label_class']) ?>-subtle text-<?= esc($event['label_class']) ?>-emphasis border border-<?= esc($event['label_class']) ?>-subtle font-monospace text-nowrap"
                      style="font-size: 0.65rem; min-width: 5.5rem; text-align: center;"><?= esc($event['label']) ?></span>
                <i class="bi <?= esc($event['icon']) ?> text-secondary flex-shrink-0"></i>
                <span class="terminal-row__desc text-body-secondary flex-grow-1 small text-truncate"><?= $event['description'] ?></span>
                <i class="bi bi-arrow-up-right text-muted flex-shrink-0 ms-auto d-none d-md-block" style="font-size: 0.7rem;"></i>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- ============================================================
     BLOG POSTS
     ============================================================ -->
<?php if (! empty($blog_posts)): ?>
<section class="container px-4 mb-5 animate-on-scroll">
    <div class="home-section-label">
        <i class="bi bi-journal-richtext me-1"></i> Latest Posts
    </div>
    <div class="row g-3">
        <?php foreach (array_slice($blog_posts, 0, 3) as $post): ?>
        <div class="col-md-6 col-xl-4 card-animate">
            <article class="card h-100 blog-card border-secondary border-opacity-25 position-relative">
                <?php if (! empty($post['slug']) && $blogUrl): ?>
                <a href="<?= esc($blogUrl) ?>/posts/<?= esc($post['slug']) ?>"
                   class="stretched-link"
                   target="_blank"
                   rel="noopener noreferrer"
                   aria-label="Read <?= esc($post['title']) ?>"></a>
                <?php endif; ?>
                <?php if (! empty($post['featured_image'])): ?>
                <img src="<?= esc(config('urls')->blog) ?>media/<?= esc($post['featured_image']) ?>"
                     class="blog-card__img card-img-top"
                     alt="<?= esc($post['title']) ?>"
                     loading="lazy">
                <?php else: ?>
                <div class="blog-card__img-placeholder d-flex align-items-center justify-content-center">
                    <i class="bi bi-journal-text"></i>
                </div>
                <?php endif; ?>
                <div class="card-body d-flex flex-column">
                    <h2 class="card-title h6 fw-semibold mb-2"><?= esc($post['title']) ?></h2>
                    <?php if (! empty($post['excerpt'])): ?>
                    <p class="card-text text-secondary small flex-grow-1 mb-3"><?= esc($post['excerpt']) ?></p>
                    <?php endif; ?>
                    <?php if (! empty($post['tags'])): ?>
                    <div class="mb-2">
                        <?php foreach (array_slice(explode(',', $post['tags']), 0, 4) as $tag): ?>
                        <?php $tag = trim($tag); if ($tag): ?>
                        <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25 me-1 mb-1 fw-normal"><?= esc($tag) ?></span>
                        <?php endif; endforeach; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="card-footer d-flex align-items-center justify-content-between border-secondary border-opacity-25 bg-transparent">
                    <span class="text-muted small"><?= esc($post['published_at_formatted']) ?></span>
                    <?php if (! empty($post['slug']) && $blogUrl): ?>
                    <a href="<?= esc($blogUrl) ?>/posts/<?= esc($post['slug']) ?>"
                       class="btn btn-sm btn-outline-primary"
                       target="_blank"
                       rel="noopener noreferrer">
                        Read <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                    <?php endif; ?>
                </div>
            </article>
        </div>
        <?php endforeach; ?>
    </div>
    <?php if ($blogUrl): ?>
    <div class="text-center mt-3">
        <a href="<?= esc($blogUrl) ?>" class="btn btn-sm btn-outline-primary" rel="noopener noreferrer">View all posts</a>
    </div>
    <?php endif; ?>
</section>
<?php endif; ?>

<!-- ============================================================
     STATUS UPDATES + BOOKMARKS
     ============================================================ -->
<?php if (! empty($statuses) || ! empty($bookmarks)): ?>
<div class="container px-4 mb-5">
    <div class="row g-4">

        <!-- STATUS UPDATES -->
        <?php if (! empty($statuses)): ?>
        <div class="col-lg-7 animate-on-scroll">
            <div class="home-section-label">
                <i class="bi bi-chat-square-dots-fill me-1"></i> Status Updates
            </div>
            <div class="d-flex flex-column gap-3">
                <?php foreach (array_slice($statuses, 0, 5) as $status): ?>
                <article class="card status-card card-animate border-secondary border-opacity-25">
                    <div class="card-body">
                        <div class="d-flex align-items-start gap-3">
                            <div class="status-card__avatar flex-shrink-0">
                                <?php if ($githubUsername): ?>
                                <img src="https://github.com/<?= rawurlencode($githubUsername) ?>.png?size=48"
                                     alt="<?= esc($githubUsername) ?>"
                                     class="rounded-circle"
                                     width="36" height="36"
                                     loading="lazy">
                                <?php else: ?>
                                <i class="bi bi-person-fill"></i>
                                <?php endif; ?>
                            </div>
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <span class="fw-semibold small text-truncate">Philip Newborough</span>
                                    <?php if (! empty($status['mastodon_url'])): ?>
                                    <a href="<?= esc($status['mastodon_url']) ?>"
                                       class="text-primary text-decoration-none small text-nowrap"
                                       target="_blank"
                                       rel="noopener noreferrer"><?= esc($status['created_at_formatted']) ?></a>
                                    <?php else: ?>
                                    <span class="text-muted small text-nowrap"><?= esc($status['created_at_formatted']) ?></span>
                                    <?php endif; ?>
                                </div>
                                <div class="status-card__content text-body-secondary small">
                                    <?= $status['content_html'] ?>
                                </div>
                                <?php if (! empty($status['media'])): ?>
                                <div class="mt-3 d-flex flex-wrap gap-2">
                                    <?php foreach ($status['media'] as $media): ?>
                                    <?php $mime = $media['mime_type'] ?? ''; $mediaUrl = esc(rtrim($statusUrl, '/') . $media['url']); ?>
                                    <?php if (str_starts_with($mime, 'image/')): ?>
                                    <img src="<?= $mediaUrl ?>"
                                         alt="<?= esc($media['description'] ?? '') ?>"
                                         class="status-card__media-img rounded"
                                         loading="lazy">
                                    <?php elseif (str_starts_with($mime, 'video/')): ?>
                                    <video controls class="status-card__media-video rounded" preload="metadata">
                                        <source src="<?= $mediaUrl ?>" type="<?= esc($mime) ?>">
                                        <?= esc($media['description'] ?? 'Video') ?>
                                    </video>
                                    <?php endif; ?>
                                    <?php endforeach; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
            <?php if ($statusUrl): ?>
            <div class="text-center mt-3">
                <a href="<?= esc($statusUrl) ?>" class="btn btn-sm btn-outline-primary" rel="noopener noreferrer">View all status updates</a>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

        <!-- BOOKMARKS -->
        <?php if (! empty($bookmarks)): ?>
        <div class="col-lg-5 animate-on-scroll">
            <div class="home-section-label">
                <i class="bi bi-bookmarks-fill me-1"></i> Bookmarks
            </div>
            <div class="d-flex flex-column gap-2">
                <?php foreach (array_slice($bookmarks, 0, 8) as $bookmark): ?>
                <a href="<?= esc($bookmark['url']) ?>"
                   class="bookmark-item card-animate d-flex align-items-center gap-3 text-decoration-none p-3 rounded border border-secondary border-opacity-25"
                   target="_blank"
                   rel="noopener noreferrer">
                    <div class="bookmark-item__icon flex-shrink-0">
                        <?php if (! empty($bookmark['favicon'])): ?>
                        <img src="<?= esc($bookmark['favicon']) ?>"
                             alt=""
                             width="16" height="16"
                             loading="lazy"
                             onerror="this.style.display='none';this.nextElementSibling.style.display='inline-block';">
                        <i class="bi bi-link-45deg text-secondary" style="display:none;"></i>
                        <?php else: ?>
                        <i class="bi bi-link-45deg text-secondary"></i>
                        <?php endif; ?>
                    </div>
                    <div class="flex-grow-1 min-w-0">
                        <div class="bookmark-item__title small fw-medium text-truncate text-body"><?= esc($bookmark['title']) ?></div>
                        <div class="text-muted" style="font-size: 0.7rem;"><?= esc($bookmark['domain']) ?></div>
                    </div>
                    <?php if (! empty($bookmark['tags'])): ?>
                    <?php $firstTag = trim(explode(',', $bookmark['tags'])[0]); ?>
                    <?php if ($firstTag): ?>
                    <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25 text-nowrap fw-normal d-none d-sm-block"><?= esc($firstTag) ?></span>
                    <?php endif; ?>
                    <?php endif; ?>
                </a>
                <?php endforeach; ?>
            </div>
            <?php if ($bookmarksUrl): ?>
            <div class="text-center mt-3">
                <a href="<?= esc($bookmarksUrl) ?>" class="btn btn-sm btn-outline-primary" rel="noopener noreferrer">View all bookmarks</a>
            </div>
            <?php endif; ?>
        </div>
        <?php endif; ?>

    </div>
</div>
<?php endif; ?>

<?= $this->endSection() ?>
