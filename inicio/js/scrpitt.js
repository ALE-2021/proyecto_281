var slideIndex = 0;
var slides = document.querySelectorAll(".normas");
var val = 0;
var slide = document.querySelectorAll(".educacion");

function mostrarSlide() {
    for (var i = 0; i < slides.length; i++) {
        slides[i].style.display = "none";
    }
    slides[slideIndex].style.display = "block";
}

function cambiarNorma(n) {
    slideIndex += n;
    if (slideIndex < 0) {
        slideIndex = slides.length - 1;
    }
    if (slideIndex >= slides.length) {
        slideIndex = 0;
    }
    mostrarSlide();
}

function mostrar(){
    for (var i = 0; i < slide.length; i++) {
        slide[i].style.display = "none";
    }
    slide[val].style.display = "block";
}
function cambiarEdu(n) {
    val += n;
    if (val < 0) {
        val = slides.length - 1;
    }
    if (val >= slide.length) {
        val = 0;
    }
    mostrar();
}

