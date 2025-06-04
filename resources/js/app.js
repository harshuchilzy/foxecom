import 'swiper/swiper-bundle.css';
import Swiper from 'swiper/bundle';
import Alpine from 'alpinejs'
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
        effect: 'coverflow',
        // grabCursor: true,
        centeredSlides: true,
        loop: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 0,
            stretch: 30,
            depth: 180,
            modifier: 2,
            slideShadows: true,
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'progressbar',
        },
        breakpoints: {
            768: {
                slidesPerView: 2.3,
            },
            1024: {
                slidesPerView: 2.7,
            },
        }
    });
});


