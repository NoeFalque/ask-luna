window.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelector('.loader').classList.remove('loader-expanded')
        document.querySelector('.loader').classList.add('loader-shrinked')

        setTimeout(() => {
            document.querySelector('.loader').classList.remove('loader-shrinked')
        }, 400)
    }, 500)
})

let toggle_notifications = document.querySelector('.toggle-notifications')

if(toggle_notifications) {
    toggle_notifications.addEventListener('click', (e) => {
        e.preventDefault()

        let xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText

                if(res != 'ok') {
                    alert('A problem occured, please try again.')
                }
            }
        }
        xhttp.open('GET', `/api/notifications`, true)
        xhttp.send()
    })
}

let dropdown_toggle = document.querySelectorAll('.dropdown-toggle')

if(dropdown_toggle) {
    dropdown_toggle.forEach((element) => {
        element.addEventListener('click', (e) => {
            e.preventDefault()
            element.classList.toggle('dropdown-toggle-active')
        })
    })
}

let nav_toggle = [
    document.querySelector('.header-nav-toggle'),
    document.querySelector('.header-nav-close')
]

if(nav_toggle) {
    nav_toggle.forEach((element) => {
        element.addEventListener('click', (e) => {
            e.preventDefault()
            let nav = document.querySelector('.header-nav')
            nav.classList.toggle('header-nav-active')
        })
    })
}

let dates_formatted = document.querySelectorAll('.date-formatted')

dates_formatted.forEach((date) => {
    let date_date  = date.innerHTML
    date.innerHTML = moment(date_date).format('MMMM Do YYYY')
})

let dates_from = document.querySelectorAll('.date-from')

dates_from.forEach((date) => {
    let date_date  = date.innerHTML
    date.innerHTML = moment(date_date).fromNow()
})
