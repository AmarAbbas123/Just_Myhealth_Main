import './bootstrap';

import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

/* ✅ ApexCharts */
import ApexCharts from 'apexcharts';
window.ApexCharts = ApexCharts;

import $ from 'jquery';
window.$ = $;
window.jQuery = $;

// ✅ Swiper Core + Styles
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle'; // Includes all modules: autoplay, navigation, pagination, etc.

document.addEventListener('DOMContentLoaded', function () {
    new Swiper('.mySwiper', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
});
