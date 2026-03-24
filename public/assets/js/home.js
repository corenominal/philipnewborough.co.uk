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
