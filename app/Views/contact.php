<?= $this->extend('templates/default') ?>

<?= $this->section('content') ?>

<!-- ============================================================
     PAGE HEADER
     ============================================================ -->
<section class="contact-header">
    <div class="contact-header__network"><canvas id="home-network-canvas" aria-hidden="true"></canvas></div>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <p class="text-primary fw-semibold font-monospace small mb-2">
                    <i class="bi bi-terminal-fill me-1"></i> $ ./contact --open
                </p>
                <h1 class="display-5 fw-bold mb-3">Get In Touch</h1>
                <p class="lead text-secondary mb-0">
                    Have a question or want to work together? Drop me a message.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ============================================================
     MAIN CONTENT
     ============================================================ -->
<section class="contact-body">
    <div class="container py-5">
        <div class="row justify-content-center g-4 g-lg-5">

            <!-- ---- Form column ---- -->
            <div class="col-lg-7">

                <?php if (session()->getFlashdata('success')): ?>
                <div class="alert border-success d-flex align-items-start gap-2 mb-4" role="alert">
                    <i class="bi bi-check-circle-fill flex-shrink-0"></i>
                    <div><?= esc(session()->getFlashdata('success')) ?></div>
                </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                <div class="alert border-danger d-flex align-items-start gap-2 mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                    <div><?= esc(session()->getFlashdata('error')) ?></div>
                </div>
                <?php endif; ?>

                <?php $validationErrors = session()->getFlashdata('errors') ?? []; ?>
                <?php if ($validationErrors): ?>
                <div class="alert border-danger mb-4" role="alert">
                    <div class="d-flex align-items-start gap-2 mb-1">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0"></i>
                        <strong>Please fix the following:</strong>
                    </div>
                    <ul class="mb-0 ps-4 mt-2">
                        <?php foreach ($validationErrors as $error): ?>
                        <li><?= esc($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="contact-form-card card">
                    <div class="card-body p-4 p-lg-5">
                        <form action="/contact/send" method="post" class="contact-form" novalidate>
                            <?= csrf_field() ?>

                            <!-- Anti-bot honeypot: must remain blank -->
                            <div class="contact-form__honeypot" aria-hidden="true">
                                <label for="website">Leave this field blank</label>
                                <input type="text" id="website" name="website" value="" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="mb-4">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="bi bi-person-fill me-1 text-primary"></i> Name
                                </label>
                                <input type="text"
                                       id="name"
                                       name="name"
                                       class="form-control contact-form__input"
                                       value="<?= esc(old('name')) ?>"
                                       placeholder="Your name"
                                       maxlength="100"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="email" class="form-label fw-semibold">
                                    <i class="bi bi-envelope-fill me-1 text-primary"></i> Email
                                </label>
                                <input type="email"
                                       id="email"
                                       name="email"
                                       class="form-control contact-form__input"
                                       value="<?= esc(old('email')) ?>"
                                       placeholder="your@email.com"
                                       maxlength="254"
                                       required>
                            </div>

                            <div class="mb-4">
                                <label for="message" class="form-label fw-semibold">
                                    <i class="bi bi-chat-text-fill me-1 text-primary"></i> Message
                                </label>
                                <textarea id="message"
                                          name="message"
                                          class="form-control contact-form__textarea"
                                          rows="7"
                                          placeholder="Your message..."
                                          maxlength="2000"
                                          required><?= esc(old('message')) ?></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100 contact-form__submit">
                                <i class="bi bi-send-fill me-2"></i> Send Message
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- ---- Info column ---- -->
            <div class="col-lg-4 col-xl-3">

                <?php if ($discord_url): ?>
                <div class="contact-discord card mb-4">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="contact-discord__icon">
                                <i class="bi bi-discord"></i>
                            </div>
                            <h2 class="h5 mb-0 fw-bold">Discord</h2>
                        </div>
                        <p class="text-secondary small mb-3">
                            Prefer a more informal chat? Join my personal Discord server and say hi! Everyone's welcome, whether you have a question, want to collaborate, or just want to chat about tech, gaming, or anything else.
                        </p>
                        <a href="<?= esc($discord_url) ?>"
                           class="btn btn-outline-primary w-100"
                           target="_blank"
                           rel="noopener noreferrer">
                            <i class="bi bi-discord me-2"></i> Join My Server
                        </a>
                    </div>
                </div>
                <?php endif; ?>

                <div class="contact-note card">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <div class="contact-note__icon">
                                <i class="bi bi-clock-fill"></i>
                            </div>
                            <h2 class="h5 mb-0 fw-bold">Response Time</h2>
                        </div>
                        <p class="text-secondary small mb-0">
                            I typically respond within a few days. For faster replies, Discord is often quicker.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

<?= $this->endSection() ?>
