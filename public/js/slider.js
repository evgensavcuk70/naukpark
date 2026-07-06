// Скрипт роботи головного слайдера.
document.addEventListener('DOMContentLoaded', function () {
    const slides = document.querySelectorAll('.slide');
    const dots = document.querySelectorAll('.dot');
    const prevBtn = document.querySelector('.prev-arrow');
    const nextBtn = document.querySelector('.next-arrow');
    let currentSlide = 0;
    const slideInterval = 5000;

    function showSlide(n) {
        if(slides.length === 0) return;

        slides[currentSlide].classList.remove('active');
        if(dots.length > 0) dots[currentSlide].classList.remove('active');

        currentSlide = (n + slides.length) % slides.length;

        slides[currentSlide].classList.add('active');
        if(dots.length > 0) dots[currentSlide].classList.add('active');
    }

    if(nextBtn) nextBtn.addEventListener('click', () => showSlide(currentSlide + 1));
    if(prevBtn) prevBtn.addEventListener('click', () => showSlide(currentSlide - 1));

    dots.forEach((dot, index) => {
        dot.addEventListener('click', () => showSlide(index));
    });

    setInterval(() => {
        showSlide(currentSlide + 1);
    }, slideInterval);
});