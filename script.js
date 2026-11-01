document.addEventListener('DOMContentLoaded', () => {
  const slides = Array.from(document.querySelectorAll('.slide'));
  if (slides.length < 2) return;
  let currentSlide = slides.findIndex((slide) => slide.classList.contains('active'));
  if (currentSlide < 0) currentSlide = 0;
  slides.forEach((slide, index) => slide.classList.toggle('active', index === currentSlide));
  window.setInterval(() => {
    slides[currentSlide].classList.remove('active');
    currentSlide = (currentSlide + 1) % slides.length;
    slides[currentSlide].classList.add('active');
  }, 5000);
});
