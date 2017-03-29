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

                if(res == 'ok') {
                    let links = document.querySelectorAll('.dropdown-notifications a.dropdown-item')

                    links.forEach((link) => {
                        link.parentNode.removeChild(link)
                    })

                    document.querySelector('.dropdown-notifications').innerHTML = `
                        <div class="dropdown-item">
                            No new notifications
                        </div>
                    `

                    document.querySelector('.notifications-count').innerHTML = ''
                }

                else {
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

let header_search = document.querySelector('.header-search')

header_search.addEventListener('click', (e) => {
    e.preventDefault()
    let search = document.querySelector('.search')
    search.classList.add('search-active')
    let body   = document.querySelector('body')
    body.classList.add('body-blocked')
})

let search_close = document.querySelector('.search-close')

search_close.addEventListener('click', (e) => {
    e.preventDefault()
    let search = document.querySelector('.search')
    search.classList.remove('search-active')
    let body   = document.querySelector('body')
    body.classList.remove('body-blocked')
})

let search_input = document.querySelector('.search-input-input')

search_input.addEventListener('keyup', () => {
    let query = search_input.value
    let $results = document.querySelector('.search-results')

    $results.innerHTML = ''

    if(query != '') {
        let xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = JSON.parse(this.responseText)

                if(res.results.length == 0) {
                    $results.innerHTML = `<p>Sorry but nothing match your request :(</p>`
                }

                else if(res.results.length > 0) {
                    let $ul = document.createElement('ul')

                    res.results.forEach((result) => {
                        let $li = document.createElement('li')
                        $li.classList.add('search-item')

                        $li.innerHTML = `<a href="${res.url}picture-of-the-day/${result.id}" class="search-link">${result.title}</a>`

                        $ul.appendChild($li)
                    })

                    $results.appendChild($ul)
                }

                else {
                    $results.innerHTML = ''
                }
            }
        }
        xhttp.open('GET', `/api/search/${query}`, true)
        xhttp.send()
    }
})
