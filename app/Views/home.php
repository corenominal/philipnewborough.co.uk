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
     PROJECT SPOTLIGHT
     ============================================================ -->
<section class="container px-4 my-5 animate-on-scroll">
    <div class="home-section-label">
        <i class="bi bi-joystick me-1"></i> Project Spotlight
    </div>
    <div class="project-carousel" id="project-carousel" aria-label="Project Spotlight carousel">
        <div class="project-carousel__track">

            <!-- Slide 1: Flatspace Commander -->
            <div class="project-carousel__slide is-active" role="group" aria-label="Project 1 of 3">
                <div class="project-card row g-0 align-items-stretch rounded overflow-hidden border border-secondary border-opacity-25 position-relative">
                    <a href="https://flatspace-commander.philipnewborough.co.uk/" class="stretched-link" target="_blank" rel="noopener noreferrer" aria-label="Play Flatspace Commander"></a>
                    <div class="col-lg-6 project-card__video-col">
                        <video
                            class="project-card__video"
                            src="/assets/video/flatspace-commander.mp4"
                            autoplay
                            loop
                            muted
                            playsinline
                            aria-label="Flatspace Commander gameplay preview">
                        </video>
                    </div>
                    <div class="col-lg-6 project-card__body d-flex flex-column justify-content-center p-4 p-lg-5">
                        <div class="project-card__badge font-monospace text-primary small mb-3">
                            <i class="bi bi-rocket me-1"></i> PWA &middot; Browser Game
                        </div>
                        <h2 class="project-card__title fw-bold mb-3">Flatspace Commander</h2>
                        <p class="project-card__desc text-secondary mb-3">A 1-bit, vertical-scrolling space trader and combat simulator for the browser - inspired by the Acornsoft/C64 classic <em>Elite</em>. Built as a Progressive Web App with pure vanilla JavaScript, HTML5 Canvas, and CSS3.</p>
                        <h3 class="h5">Features</h3>
                        <ul class="project-card__features text-secondary small mb-4">
                            <li><strong class="text-body-secondary">Flight</strong> - Scroll between star systems, dodge asteroids, mine minerals, survive combat encounters.</li>
                            <li><strong class="text-body-secondary">Combat</strong> - 1-bit wireframe dogfights against pirates, traders, and Thargoid aliens. Pulse, Beam &amp; Military lasers, shields, and cargo pod drops.</li>
                            <li><strong class="text-body-secondary">Trade</strong> - 17 Elite-style commodities with prices driven by tech level, government, and economy. Buy low, sell high.</li>
                            <li><strong class="text-body-secondary">Equipment</strong> - Upgrade your Cobra with mining lasers, shield generators, docking computers, galactic hyperdrive, and more.</li>
                            <li><strong class="text-body-secondary">Galaxy Map</strong> - 256 systems procedurally generated via a seeded LCG - identical on every device, no server required.</li>
                        </ul>
                        <div>
                            <a href="https://flatspace-commander.philipnewborough.co.uk/" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-play-circle me-1"></i> Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 2: Emoji Slots RPG -->
            <div class="project-carousel__slide" role="group" aria-label="Project 2 of 3">
                <div class="project-card row g-0 align-items-stretch rounded overflow-hidden border border-secondary border-opacity-25 position-relative">
                    <a href="https://emojislotsrpg.philipnewborough.co.uk/" class="stretched-link" target="_blank" rel="noopener noreferrer" aria-label="Play Emoji Slots RPG"></a>
                    <div class="col-lg-6 project-card__video-col">
                        <video
                            class="project-card__video"
                            src="/assets/video/emojislotsrpg.mp4"
                            autoplay
                            loop
                            muted
                            playsinline
                            aria-label="Emoji Slots RPG gameplay preview">
                        </video>
                    </div>
                    <div class="col-lg-6 project-card__body d-flex flex-column justify-content-center p-4 p-lg-5">
                        <div class="project-card__badge font-monospace text-primary small mb-3">
                            <i class="bi bi-controller me-1"></i> PWA &middot; Browser Game
                        </div>
                        <h2 class="project-card__title fw-bold mb-3">Emoji Slots RPG</h2>
                        <p class="project-card__desc text-secondary mb-4">Step into a glowing neon arcade, circa 1988. Emoji Slots is a browser-based fruit machine with full UK pub-style mechanics: spin three emoji reels, hold wheels between spins, nudge them up or down into line, and gamble your winnings through bonus rounds - Higher/Lower, Pick a Box, and Spin the Wheel. Random arcade encounters throw RPG-style events into the mix. Match cherries, unicorns, or the elusive &#x1F4AF; to fill your pockets. Hit a triple &#x1F4A9; and watch your coins vanish. Hit &#x1F480;&#x1F480;&#x1F480; and it&apos;s game over. Built with a synthwave CRT aesthetic, arcade sound effects, and background music.</p>
                        <div>
                            <a href="https://emojislotsrpg.philipnewborough.co.uk/" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-play-circle me-1"></i> Play Now
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Slide 3: Favicon & PWA Icon Generator -->
            <div class="project-carousel__slide" role="group" aria-label="Project 3 of 3">
                <div class="project-card row g-0 align-items-stretch rounded overflow-hidden border border-secondary border-opacity-25 position-relative">
                    <a href="https://favicons-pwa.philipnewborough.co.uk/" class="stretched-link" target="_blank" rel="noopener noreferrer" aria-label="Open Favicon and PWA Icon Generator"></a>
                    <div class="col-lg-6 project-card__video-col">
                        <video
                            class="project-card__video"
                            src="/assets/video/favicon-pwa-icon-generator.mp4"
                            loop
                            muted
                            playsinline
                            aria-label="Favicon and PWA Icon Generator preview">
                        </video>
                    </div>
                    <div class="col-lg-6 project-card__body d-flex flex-column justify-content-center p-4 p-lg-5">
                        <div class="project-card__badge font-monospace text-primary small mb-3">
                            <i class="bi bi-image me-1"></i> PWA &middot; Browser Tool
                        </div>
                        <h2 class="project-card__title fw-bold mb-3">Favicon &amp; PWA Icon Generator</h2>
                        <p class="project-card__desc text-secondary mb-4">A free, browser-based tool that generates every icon size your website or Progressive Web App needs - no server uploads, no account required. All processing happens entirely in the browser using the Canvas API.</p>
                        <div>
                            <a href="https://favicons-pwa.philipnewborough.co.uk/" class="btn btn-outline-primary" target="_blank" rel="noopener noreferrer">
                                <i class="bi bi-box-arrow-up-right me-1"></i> Open Tool
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Carousel controls -->
        <div class="project-carousel__controls d-flex align-items-center justify-content-center gap-3 mt-3">
            <button class="project-carousel__btn" id="project-prev" aria-label="Previous project">
                <i class="bi bi-chevron-left"></i>
            </button>
            <div class="project-carousel__dots" role="tablist" aria-label="Project slides">
                <button class="project-carousel__dot active" role="tab" aria-selected="true" aria-label="Flatspace Commander" data-index="0"></button>
                <button class="project-carousel__dot" role="tab" aria-selected="false" aria-label="Emoji Slots RPG" data-index="1"></button>
                <button class="project-carousel__dot" role="tab" aria-selected="false" aria-label="Favicon and PWA Icon Generator" data-index="2"></button>
            </div>
            <button class="project-carousel__btn" id="project-next" aria-label="Next project">
                <i class="bi bi-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

<!-- ============================================================
     GITHUB ACTIVITY
     ============================================================ -->
<?php if (! empty($github_events)): ?>
<section class="container px-4 my-5 animate-on-scroll">
    <div class="home-section-label">
        <i class="bi bi-github me-1"></i> Recent Public Activity
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
                                    <button type="button"
                                            class="status-media-trigger border-0 bg-transparent p-0"
                                            data-media-type="image"
                                            data-media-src="<?= $mediaUrl ?>"
                                            data-media-alt="<?= esc($media['description'] ?? '') ?>"
                                            aria-label="View image larger">
                                        <img src="<?= $mediaUrl ?>"
                                             alt="<?= esc($media['description'] ?? '') ?>"
                                             class="status-card__media-img rounded"
                                             loading="lazy">
                                    </button>
                                    <?php elseif (str_starts_with($mime, 'video/')): ?>
                                    <div class="position-relative">
                                        <video controls class="status-card__media-video rounded" preload="metadata">
                                            <source src="<?= $mediaUrl ?>" type="<?= esc($mime) ?>">
                                            <?= esc($media['description'] ?? 'Video') ?>
                                        </video>
                                        <button type="button"
                                                class="status-media-trigger position-absolute top-0 end-0 m-1 btn btn-sm btn-dark opacity-75"
                                                data-media-type="video"
                                                data-media-src="<?= $mediaUrl ?>"
                                                data-media-mime="<?= esc($mime) ?>"
                                                data-media-alt="<?= esc($media['description'] ?? '') ?>"
                                                title="Expand video"
                                                aria-label="Expand video">
                                            <i class="bi bi-fullscreen" aria-hidden="true"></i>
                                        </button>
                                    </div>
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
                   class="bookmark-item card-animate d-flex flex-column gap-2 text-decoration-none p-3 rounded border border-secondary border-opacity-25"
                   target="_blank"
                   rel="noopener noreferrer">
                    <div class="d-flex align-items-center gap-3 overflow-hidden">
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
                    </div>
                    <?php if (! empty($bookmark['tags'])): ?>
                    <div class="d-flex flex-wrap gap-1">
                        <?php foreach (array_slice(explode(',', $bookmark['tags']), 0, 3) as $tag): ?>
                        <?php $tag = trim($tag); if ($tag): ?>
                        <span class="badge bg-secondary bg-opacity-25 text-secondary border border-secondary border-opacity-25 text-nowrap fw-normal"><?= esc($tag) ?></span>
                        <?php endif; endforeach; ?>
                    </div>
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

<!-- ============================================================
     MEDIA MODAL
     ============================================================ -->
<div class="modal fade" id="mediaModal" tabindex="-1" aria-labelledby="mediaModalLabel" aria-modal="true" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content bg-dark">
            <div class="modal-header py-2">
                <span class="modal-title text-body-secondary small" id="mediaModalLabel"></span>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-2 text-center" id="mediaModalBody"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
