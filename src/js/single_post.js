let zoom_action = document.querySelector('.zoom-action')
let zoom_close  = document.querySelector('.zoom-close')
let zoom        = document.querySelector('.single-zoom')

zoom_action.addEventListener('click', (e) => {
    e.preventDefault()
    zoom.classList.add('single-zoom-visible')
})

zoom_close.addEventListener('click', (e) => {
    e.preventDefault()
    zoom.classList.remove('single-zoom-visible')
})

// Scroll to anchor:
function smooth_scroll() {
    let hash = location.hash
    let comment_selector = hash.substr(1, hash.length)
    let $comment = document.querySelector("[data-id ='" + comment_selector +"']")
    if($comment){
        let comment_posY = window.scrollY + $comment.getBoundingClientRect().top
        let scroll = comment_posY
        let scroll_anim = setInterval( function(){
            window.scrollTo(0, comment_posY - scroll)
            scroll -= scroll/100;
            if(scroll< 80) {
                clearInterval(scroll_anim)
            }
        }, 5)
    }
}

smooth_scroll()
