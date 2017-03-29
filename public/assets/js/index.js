'use strict';

var header = document.querySelector('.header');

window.addEventListener('scroll', function () {
    if (window.scrollY >= 30) {
        header.classList.add('header-scrolled');
    } else {
        header.classList.remove('header-scrolled');
    }
});