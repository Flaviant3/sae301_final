let slideIndex = 1;
showSlides();

function showSlides() {
    const slides = document.querySelectorAll('.slide');
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = 'none';
    }
    slides[slideIndex - 1].style.display = 'block';
}

function plusSlides(n) {
    slideIndex += n;

    if (slideIndex > 3) {
        slideIndex = 1;
    }

    if (slideIndex < 1) {
        slideIndex = 3;
    }

    showSlides();
}

document.querySelector('.prev').addEventListener('click', function() {
    plusSlides(-1);
});

document.querySelector('.next').addEventListener('click', function() {
    plusSlides(1);
});
