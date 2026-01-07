document.addEventListener('DOMContentLoaded', function() {
    let currentSlideIndex = 0;
    const slides = document.querySelectorAll('#promoSlider .slider-item');
    const dots = document.querySelectorAll('.dot');
    const slider = document.getElementById('promoSlider');

    function showSlide(index) {
        if (slider) {
            slider.style.transform = `translateX(-${index * 100}%)`;
            
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.style.backgroundColor = 'white';
                } else {
                    dot.style.backgroundColor = 'rgba(255, 255, 255, 0.6)';
                }
            });
        }
    }

    window.currentSlide = function(slideNumber) {
        currentSlideIndex = slideNumber - 1;
        showSlide(currentSlideIndex);
    }

    function nextSlide() {
        currentSlideIndex = (currentSlideIndex + 1) % slides.length;
        showSlide(currentSlideIndex);
    }

    // Initialize first slide
    showSlide(0);
    
    // Auto slide every 5 seconds
    setInterval(nextSlide, 5000);
});