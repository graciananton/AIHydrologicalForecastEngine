/**************************************************************************
 *
 *  OTTAWA RIVER LANDING PAGE
 *
 *************************************************************************/


/***********************************************************************
 * HERO SLIDESHOW
 ***********************************************************************/

const slides = document.querySelectorAll(".slide");
const dots = document.querySelectorAll(".dot");

const previousButton = document.querySelector(".previous");
const nextButton = document.querySelector(".next");

const slider = document.querySelector(".hero");

let currentSlide = 0;

const slideInterval = 5000;

let slideshow;


/***********************************************************************
 * INITIALIZE
 ***********************************************************************/

function initializeHeroSlider(){

    showSlide(currentSlide);

    startSlideshow();

}


/***********************************************************************
 * SHOW SLIDE
 ***********************************************************************/

function showSlide(index){

    slides.forEach(slide=>{

        slide.classList.remove("active");

    });

    dots.forEach(dot=>{

        dot.classList.remove("active");

    });

    slides[index].classList.add("active");

    dots[index].classList.add("active");

}


/***********************************************************************
 * NEXT
 ***********************************************************************/

function nextSlide(){

    currentSlide++;

    if(currentSlide >= slides.length){

        currentSlide = 0;

    }

    showSlide(currentSlide);

}


/***********************************************************************
 * PREVIOUS
 ***********************************************************************/

function previousSlide(){

    currentSlide--;

    if(currentSlide < 0){

        currentSlide = slides.length-1;

    }

    showSlide(currentSlide);

}


/***********************************************************************
 * AUTO PLAY
 ***********************************************************************/

function startSlideshow(){

    stopSlideshow();

    slideshow = setInterval(function(){

        nextSlide();

    }, slideInterval);

}


/***********************************************************************
 * STOP
 ***********************************************************************/

function stopSlideshow(){

    clearInterval(slideshow);

}


/***********************************************************************
 * BUTTON EVENTS
 ***********************************************************************/

nextButton.addEventListener("click",function(){

    nextSlide();

    startSlideshow();

});



previousButton.addEventListener("click",function(){

    previousSlide();

    startSlideshow();

});


/***********************************************************************
 * DOT EVENTS
 ***********************************************************************/

dots.forEach(function(dot,index){

    dot.addEventListener("click",function(){

        currentSlide = index;

        showSlide(currentSlide);

        startSlideshow();

    });

});


/***********************************************************************
 * PAUSE ON HOVER
 ***********************************************************************/

slider.addEventListener("mouseenter",function(){

    stopSlideshow();

});


slider.addEventListener("mouseleave",function(){

    startSlideshow();

});


/***********************************************************************
 * KEYBOARD
 ***********************************************************************/

document.addEventListener("keydown",function(event){

    if(event.key === "ArrowLeft"){

        previousSlide();

        startSlideshow();

    }

    if(event.key === "ArrowRight"){

        nextSlide();

        startSlideshow();

    }

});


/***********************************************************************
 * OPTIONAL TOUCH SWIPE
 ***********************************************************************/

let touchStartX = 0;
let touchEndX = 0;

slider.addEventListener("touchstart",function(event){

    touchStartX = event.changedTouches[0].screenX;

});


slider.addEventListener("touchend",function(event){

    touchEndX = event.changedTouches[0].screenX;

    if(touchStartX - touchEndX > 50){

        nextSlide();

        startSlideshow();

    }

    if(touchEndX - touchStartX > 50){

        previousSlide();

        startSlideshow();

    }

});


/***********************************************************************
 * START
 ***********************************************************************/

initializeHeroSlider();