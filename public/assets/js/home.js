'use strict';

// -- Tagline rotator ---------------------------------------------------------

const taglineEl = document.getElementById('hero-tagline');
const taglines = taglineEl
  ? JSON.parse(taglineEl.dataset.taglines || '[]')
  : [];

let taglineIndex = 0;

function rotateTagline() {
  if (!taglineEl) return;

  taglineEl.classList.add('tagline--exiting');

  setTimeout(() => {
    taglineIndex = (taglineIndex + 1) % taglines.length;
    taglineEl.textContent = taglines[taglineIndex];
    taglineEl.classList.remove('tagline--exiting');
    taglineEl.classList.add('tagline--entering');

    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        taglineEl.classList.remove('tagline--entering');
      });
    });
  }, 260);
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
