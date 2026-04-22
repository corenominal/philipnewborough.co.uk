'use strict';

// -- Tagline rotator ---------------------------------------------------------

const taglineEl = document.getElementById('hero-tagline');
const taglines = taglineEl
  ? JSON.parse(taglineEl.dataset.taglines || '[]')
  : [];

let taglineIndex = 0;

const MATRIX_CHARS = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&<>?/|';

function randomChar() {
  return MATRIX_CHARS[Math.floor(Math.random() * MATRIX_CHARS.length)];
}

function matrixDecodeText(element, newText, duration = 560) {
  const len = newText.length;
  const frameMs = 28;
  const totalFrames = Math.round(duration / frameMs);
  const scrambleFrames = Math.round(totalFrames * 0.3);
  const decodeFrames = totalFrames - scrambleFrames;
  let frame = 0;

  const id = setInterval(() => {
    frame += 1;
    let display = '';

    for (let i = 0; i < len; i += 1) {
      if (newText[i] === ' ') {
        display += ' ';
      } else if (frame > scrambleFrames) {
        const decodeFrame = frame - scrambleFrames;
        if (decodeFrame >= Math.round((i / len) * decodeFrames)) {
          display += newText[i];
        } else {
          display += randomChar();
        }
      } else {
        display += randomChar();
      }
    }

    element.textContent = display;

    if (frame >= totalFrames) {
      clearInterval(id);
      element.textContent = newText;
    }
  }, frameMs);
}

function rotateTagline() {
  if (!taglineEl) return;
  taglineIndex = (taglineIndex + 1) % taglines.length;
  matrixDecodeText(taglineEl, taglines[taglineIndex]);
}

if (taglineEl && taglines.length > 1) {
  setInterval(rotateTagline, 3200);
}

// -- Scroll-triggered animations ---------------------------------------------

const scrollObserver = new IntersectionObserver(
  (entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        scrollObserver.unobserve(entry.target);
      }
    });
  },
  { threshold: 0.07 },
);

document.querySelectorAll('.animate-on-scroll').forEach((el) => {
  scrollObserver.observe(el);
});

// -- Project carousel --------------------------------------------------------

const projectCarousel = document.getElementById('project-carousel');

if (projectCarousel) {
  const slides = Array.from(projectCarousel.querySelectorAll('.project-carousel__slide'));
  const dots = Array.from(projectCarousel.querySelectorAll('.project-carousel__dot'));
  const prevBtn = document.getElementById('project-prev');
  const nextBtn = document.getElementById('project-next');
  let current = 0;

  function goToSlide(index) {
    const leavingVideo = slides[current].querySelector('video');
    if (leavingVideo) leavingVideo.pause();

    slides[current].classList.remove('is-active');
    dots[current].classList.remove('active');
    dots[current].setAttribute('aria-selected', 'false');

    current = (index + slides.length) % slides.length;

    slides[current].classList.add('is-active');
    dots[current].classList.add('active');
    dots[current].setAttribute('aria-selected', 'true');

    const enteringVideo = slides[current].querySelector('video');
    if (enteringVideo) enteringVideo.play().catch(() => {});
  }

  if (prevBtn) prevBtn.addEventListener('click', () => goToSlide(current - 1));
  if (nextBtn) nextBtn.addEventListener('click', () => goToSlide(current + 1));

  dots.forEach((dot) => {
    dot.addEventListener('click', () => goToSlide(Number(dot.dataset.index)));
  });

  projectCarousel.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') goToSlide(current - 1);
    if (e.key === 'ArrowRight') goToSlide(current + 1);
  });
}

// -- Status media modal -------------------------------------------------------

const mediaModal = document.getElementById('mediaModal');

if (mediaModal) {
  document.querySelectorAll('.status-media-trigger').forEach((btn) => {
    btn.addEventListener('click', () => {
      const { mediaType, mediaSrc, mediaAlt = '', mediaMime = '' } = btn.dataset;
      const body = document.getElementById('mediaModalBody');
      const label = document.getElementById('mediaModalLabel');

      body.innerHTML = '';
      label.textContent = mediaAlt;

      if (mediaType === 'image') {
        const img = document.createElement('img');
        img.src = mediaSrc;
        img.alt = mediaAlt;
        img.className = 'img-fluid rounded';
        body.appendChild(img);
      } else if (mediaType === 'video') {
        const video = document.createElement('video');
        video.controls = true;
        video.autoplay = true;
        video.className = 'w-100 rounded';
        const source = document.createElement('source');
        source.src = mediaSrc;
        source.type = mediaMime;
        video.appendChild(source);
        body.appendChild(video);
      }

      bootstrap.Modal.getOrCreateInstance(mediaModal).show();
    });
  });

  mediaModal.addEventListener('hidden.bs.modal', () => {
    document.getElementById('mediaModalBody').innerHTML = '';
  });
}
