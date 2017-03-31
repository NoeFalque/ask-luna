'use strict';

/*
 * Hide loader when DOM content is loaded
 */
window.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        document.querySelector('.loader').classList.remove('loader-expanded');
        document.querySelector('.loader').classList.add('loader-shrinked');

        setTimeout(function () {
            document.querySelector('.loader').classList.remove('loader-shrinked');
        }, 400);
    }, 500);
});

/*
 * Notifications toggle
 */
var toggle_notifications = document.querySelector('.toggle-notifications');

if (toggle_notifications) {
    toggle_notifications.addEventListener('click', function (e) {
        e.preventDefault();

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.responseText;

                if (res == 'ok') {
                    var links = document.querySelectorAll('.dropdown-notifications a.dropdown-item');

                    links.forEach(function (link) {
                        link.parentNode.removeChild(link);
                    });

                    document.querySelector('.dropdown-notifications').innerHTML = '\n                        <div class="dropdown-item">\n                            No new notifications\n                        </div>\n                    ';

                    if (document.querySelector('.notifications-count')) document.querySelector('.notifications-count').innerHTML = '';
                } else {
                    alert('A problem occured, please try again.');
                }
            }
        };
        xhttp.open('GET', '/api/notifications', true);
        xhttp.send();
    });
}

/*
 * Dropdowns toggle show
 */
var dropdown_toggle = document.querySelectorAll('.dropdown-toggle');

if (dropdown_toggle) {
    dropdown_toggle.forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            element.classList.toggle('dropdown-toggle-active');
        });
    });
}

var nav_toggle = [document.querySelector('.header-nav-toggle'), document.querySelector('.header-nav-close')];

if (nav_toggle) {
    nav_toggle.forEach(function (element) {
        element.addEventListener('click', function (e) {
            e.preventDefault();
            var nav = document.querySelector('.header-nav');
            nav.classList.toggle('header-nav-active');
        });
    });
}

/*
 * Moment.js formatted dates
 */
var dates_formatted = document.querySelectorAll('.date-formatted');

dates_formatted.forEach(function (date) {
    var date_date = date.innerHTML;
    date.innerHTML = moment(date_date).format('MMMM Do YYYY');
});

var dates_from = document.querySelectorAll('.date-from');

dates_from.forEach(function (date) {
    var date_date = date.innerHTML;
    date.innerHTML = moment(date_date).fromNow();
});

/*
 * Global search
 */
var header_search = document.querySelector('.header-search');

if (header_search) {
    header_search.addEventListener('click', function (e) {
        e.preventDefault();
        var search = document.querySelector('.search');
        search.classList.add('search-active');
        var body = document.querySelector('body');
        body.classList.add('body-blocked');
    });
}

var search_close = document.querySelector('.search-close');

if (search_close) {
    search_close.addEventListener('click', function (e) {
        e.preventDefault();
        var search = document.querySelector('.search');
        search.classList.remove('search-active');
        var body = document.querySelector('body');
        body.classList.remove('body-blocked');
    });
}

var search_input = document.querySelector('.search-input-input');

if (search_input) {
    search_input.addEventListener('keyup', function () {
        var query = search_input.value;
        var $results = document.querySelector('.search-results');

        $results.innerHTML = '';

        if (query != '') {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var res = JSON.parse(this.responseText);

                    if (res.results.length == 0) {
                        $results.innerHTML = '<p>Sorry but nothing match your request :(</p>';
                    } else if (res.results.length > 0) {
                        var $ul = document.createElement('ul');

                        res.results.forEach(function (result) {
                            var $li = document.createElement('li');
                            $li.classList.add('search-item');

                            $li.innerHTML = '\n                                <a href="' + res.url + 'picture-of-the-day/' + result.id + '" class="search-link">\n                                    <div class="search-picture" style="background-image: url(\'' + res.url + 'uploads/' + result.url + '\')"></div>\n                                    <h3 class="search-title">' + result.title + '</h3>\n                                    <p class="search-date">' + moment(result.date).fromNow() + '</p>\n                                </a>\n                            ';

                            $ul.appendChild($li);
                        });

                        $results.appendChild($ul);
                    } else {
                        $results.innerHTML = '';
                    }
                }
            };
            xhttp.open('GET', '/api/search/' + query, true);
            xhttp.send();
        }
    });
}

/*
 * Background parallax on jumbotrons
 */
var $bg = document.querySelector('.jumbotron');

if ($bg) {
    $bg.style.backgroundSize = "100% auto";
    $bg.style.backgroundPosition = "center 0px";

    window.addEventListener('scroll', function () {
        if (window.scrollY < window.innerHeight) {
            $bg.style.backgroundPosition = 'center ' + window.scrollY * 0.5 + 'px';
        }
    });
}