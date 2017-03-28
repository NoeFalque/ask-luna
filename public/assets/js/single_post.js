'use strict';

var zoom_action = document.querySelector('.zoom-action');
var zoom_close = document.querySelector('.zoom-close');
var zoom = document.querySelector('.single-zoom');

zoom_action.addEventListener('click', function (e) {
    e.preventDefault();
    zoom.classList.add('single-zoom-visible');
});

zoom_close.addEventListener('click', function (e) {
    e.preventDefault();
    zoom.classList.remove('single-zoom-visible');
});