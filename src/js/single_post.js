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
