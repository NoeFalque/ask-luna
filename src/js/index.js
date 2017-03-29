let header = document.querySelector('.header')

window.addEventListener('scroll', () => {
    if(window.scrollY >= 30) {
        header.classList.add('header-scrolled')
    }

    else {
        header.classList.remove('header-scrolled')
    }
})
