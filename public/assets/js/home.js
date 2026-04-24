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

// -- Status media ---------------------------------------------------------

const statusSection    = document.querySelector('.home-section--status');
const imageModalEl     = document.getElementById('timeline-image-modal');
const imageModalImg    = document.getElementById('timeline-image-modal-img');
const imageModalWrap   = document.getElementById('timeline-image-modal-img-wrap');
const imageModalCapt   = document.getElementById('timeline-image-modal-caption');
const imageModal       = imageModalEl && window.bootstrap
  ? window.bootstrap.Modal.getOrCreateInstance(imageModalEl)
  : null;

const initializeImageShimmer = (rootElement) => {
  rootElement.querySelectorAll('.timeline__media-image').forEach((image) => {
    if (image.dataset.shimmerInitialized === '1') {
      return;
    }

    image.dataset.shimmerInitialized = '1';

    const mediaItem = image.closest('.timeline__media-item');

    if (!mediaItem) {
      return;
    }

    const markAsLoaded = () => {
      mediaItem.classList.add('has-loaded');
      image.classList.add('is-loaded');
    };

    if (image.complete && image.naturalWidth > 0) {
      markAsLoaded();
      return;
    }

    image.addEventListener('load', markAsLoaded, { once: true });
    image.addEventListener('error', () => {
      mediaItem.classList.add('has-loaded');
    }, { once: true });
  });

  rootElement.querySelectorAll('.timeline__media-video').forEach((video) => {
    if (video.dataset.shimmerInitialized === '1') {
      return;
    }

    video.dataset.shimmerInitialized = '1';

    const mediaItem = video.closest('.timeline__media-item');

    if (!mediaItem) {
      return;
    }

    const markAsLoaded = () => mediaItem.classList.add('has-loaded');

    if (video.readyState >= 1) {
      markAsLoaded();
      return;
    }

    video.addEventListener('loadedmetadata', markAsLoaded, { once: true });
    video.addEventListener('error', markAsLoaded, { once: true });
  });
};

if (statusSection) {
  initializeImageShimmer(statusSection);

  if (imageModal && imageModalImg && imageModalCapt) {
    statusSection.addEventListener('click', (event) => {
      const clickedImage = event.target.closest('.timeline__media-image');

      if (!clickedImage) {
        return;
      }

      event.preventDefault();

      const fullSrc  = clickedImage.currentSrc || clickedImage.src;
      const altText  = clickedImage.getAttribute('alt') || 'Full size image';
      const imgWidth  = parseInt(clickedImage.dataset.width, 10) || 0;
      const imgHeight = parseInt(clickedImage.dataset.height, 10) || 0;

      imageModalImg.classList.remove('is-loaded');
      imageModalImg.alt = altText;

      if (imageModalWrap) {
        imageModalWrap.classList.remove('has-loaded');
        imageModalWrap.style.aspectRatio = '';
        imageModalWrap.style.maxHeight   = '';
        imageModalWrap.style.maxWidth    = '';

        if (imgWidth > 0 && imgHeight > 0) {
          imageModalWrap.style.aspectRatio = `${imgWidth} / ${imgHeight}`;

          if (imgHeight > imgWidth) {
            imageModalWrap.style.maxHeight = '78vh';
            imageModalWrap.style.maxWidth  = `calc(78vh * ${imgWidth} / ${imgHeight})`;
          }
        }
      }

      const markModalLoaded = () => {
        imageModalImg.classList.add('is-loaded');
        if (imageModalWrap) {
          imageModalWrap.classList.add('has-loaded');
        }
      };

      imageModalImg.addEventListener('load', markModalLoaded, { once: true });
      imageModalImg.addEventListener('error', markModalLoaded, { once: true });

      imageModalImg.src = fullSrc;

      if (imageModalCapt) {
        imageModalCapt.textContent = altText;
      }

      imageModal.show();
    });

    imageModalEl.addEventListener('hidden.bs.modal', () => {
      imageModalImg.src = '';
      imageModalImg.classList.remove('is-loaded');
      if (imageModalWrap) {
        imageModalWrap.classList.remove('has-loaded');
      }
    });
  }
}
