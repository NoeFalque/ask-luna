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

// Scroll to anchor:
function smooth_scroll() {
    var hash = location.hash;
    var comment_selector = hash.substr(1, hash.length);
    var $comment = document.querySelector("[data-id ='" + comment_selector + "']");
    if ($comment) {
        var comment_posY = window.scrollY + $comment.getBoundingClientRect().top;
        var scroll = comment_posY;
        var scroll_anim = setInterval(function () {
            window.scrollTo(0, comment_posY - scroll);
            scroll -= scroll / 100;
            if (scroll < 80) {
                clearInterval(scroll_anim);
            }
        }, 5);
    }
}

smooth_scroll();