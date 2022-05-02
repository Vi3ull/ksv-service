import Swiper, { Autoplay, Pagination } from "swiper";
import throttle from "@c/utils/throttle/_";

const options = {
  modules: [Autoplay, Pagination],
  loop: true,
  slidesPerView: 1,
  speed: 400,
  autoplay: {
    delay: 5000,
    disableOnInteraction: false,
    pauseOnMouseEnter: true,
  },
  wrapperClass: "js-carousel-inner",
  slideClass: "js-carousel-slide",
  pagination: {
    el: ".carousel__pagination",
    clickable: true,
    bulletActiveClass: "carousel__pagination-bullet--state--active",
    bulletClass: "carousel__pagination-bullet",
    bulletElement: "li",
  },
}; 


export default function initCarousel($carousel) {
  const init = () => {
    $carousel.classList.add("carousel--inited");
  
    const slidesPerView = window.getComputedStyle($carousel, null).getPropertyValue("--carouselSlidesCount");
  
    options.slidesPerView = parseInt(slidesPerView);
    options.pagination.el = $carousel.querySelector(".carousel__pagination");
    
    const carousel = new Swiper($carousel, options);
  }

  init();
  
  const optimizedHandler = throttle(init, 250);
  window.addEventListener("resize", optimizedHandler)
};



