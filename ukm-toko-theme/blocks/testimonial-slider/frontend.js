/**
 * Frontend JavaScript untuk Slider Testimonial UKM.
 * Ringan, tanpa library eksternal (vanilla JS), performa tinggi, aksesibel.
 *
 * @package ukm-toko-theme
 */
(function () {
  'use strict';

  function initSliders() {
    var sliders = document.querySelectorAll('.ukm-testimonial-slider');
    if (!sliders.length) return;

    sliders.forEach(function (slider) {
      var slides = slider.querySelectorAll('.ukm-testimonial-card');
      var dots = slider.querySelectorAll('.ukm-testimonial-slider__dot');
      var prevBtn = slider.querySelector('.ukm-testimonial-slider__btn--prev');
      var nextBtn = slider.querySelector('.ukm-testimonial-slider__btn--next');

      if (slides.length <= 1) return;

      var currentIndex = 0;
      var totalSlides = slides.length;
      var autoplay = slider.dataset.autoplay === 'true';
      var delay = parseInt(slider.dataset.delay, 10) || 5000;
      var timer = null;
      var touchStartX = 0;
      var touchEndX = 0;

      function goToSlide(index) {
        if (index < 0) {
          currentIndex = totalSlides - 1;
        } else if (index >= totalSlides) {
          currentIndex = 0;
        } else {
          currentIndex = index;
        }

        slides.forEach(function (slide, i) {
          if (i === currentIndex) {
            slide.classList.add('is-active');
            slide.setAttribute('aria-hidden', 'false');
          } else {
            slide.classList.remove('is-active');
            slide.setAttribute('aria-hidden', 'true');
          }
        });

        dots.forEach(function (dot, i) {
          if (i === currentIndex) {
            dot.classList.add('is-active');
            dot.setAttribute('aria-selected', 'true');
          } else {
            dot.classList.remove('is-active');
            dot.setAttribute('aria-selected', 'false');
          }
        });
      }

      function nextSlide() {
        goToSlide(currentIndex + 1);
      }

      function prevSlide() {
        goToSlide(currentIndex - 1);
      }

      function startTimer() {
        if (autoplay && !timer) {
          timer = setInterval(nextSlide, delay);
        }
      }

      function stopTimer() {
        if (timer) {
          clearInterval(timer);
          timer = null;
        }
      }

      // Event Listeners
      if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
          e.preventDefault();
          stopTimer();
          prevSlide();
          startTimer();
        });
      }

      if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
          e.preventDefault();
          stopTimer();
          nextSlide();
          startTimer();
        });
      }

      dots.forEach(function (dot) {
        dot.addEventListener('click', function (e) {
          e.preventDefault();
          var slideIndex = parseInt(dot.dataset.slide, 10);
          if (!isNaN(slideIndex)) {
            stopTimer();
            goToSlide(slideIndex);
            startTimer();
          }
        });
      });

      // Pause on hover
      slider.addEventListener('mouseenter', stopTimer);
      slider.addEventListener('mouseleave', startTimer);
      slider.addEventListener('focusin', stopTimer);
      slider.addEventListener('focusout', startTimer);

      // Touch Swipe Support
      slider.addEventListener('touchstart', function (e) {
        touchStartX = e.changedTouches[0].screenX;
      }, { passive: true });

      slider.addEventListener('touchend', function (e) {
        touchEndX = e.changedTouches[0].screenX;
        var diff = touchEndX - touchStartX;
        if (Math.abs(diff) > 40) {
          stopTimer();
          if (diff < 0) {
            nextSlide();
          } else {
            prevSlide();
          }
          startTimer();
        }
      }, { passive: true });

      // Keyboard navigation
      slider.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowLeft') {
          stopTimer();
          prevSlide();
          startTimer();
        } else if (e.key === 'ArrowRight') {
          stopTimer();
          nextSlide();
          startTimer();
        }
      });

      // Start initial
      goToSlide(0);
      startTimer();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSliders);
  } else {
    initSliders();
  }
})();
