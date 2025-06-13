import 'swiper/swiper-bundle.css';
import Swiper from 'swiper/bundle';

document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
        effect: 'coverflow',
        // grabCursor: true,
        centeredSlides: false,
        loop: false,
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

    new Swiper('.mySecondSwiper', {
        slidesPerView: 'auto',
        spaceBetween: 20,
        freeMode: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            340: {
                slidesPerView: 2.2,
            },
            768: {
                slidesPerView: 4,
            },
            1024: {
                slidesPerView: 4,
            },
        }
    });
});


