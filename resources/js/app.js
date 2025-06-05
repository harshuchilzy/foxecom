import 'swiper/swiper-bundle.css';
import Swiper from 'swiper/bundle';
import Alpine from 'alpinejs'
window.Alpine = Alpine;
Alpine.start();

document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
        effect: 'coverflow',
        // grabCursor: true,
        centeredSlides: false,
        loop: true,
        slidesPerView: 'auto',
        coverflowEffect: {
            rotate: 0,
            stretch: 10,
            depth: 150,
            modifier: 2,
            slideShadows: true,
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'progressbar',
        },
        breakpoints: {
            340: {
                centeredSlides: true,
                slidesPerView: 1.1,
            },
            768: {
                slidesPerView: 3,
            },
            1024: {
                slidesPerView: 3,
            },
        }
    });
});


