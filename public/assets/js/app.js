'use strict';

window.addEventListener('DOMContentLoaded', function () {
    setTimeout(function () {
        document.querySelector('.loader').classList.remove('loader-expanded');
        document.querySelector('.loader').classList.add('loader-shrinked');

        setTimeout(function () {
            document.querySelector('.loader').classList.remove('loader-shrinked');
        }, 400);
    }, 500);
});

var toggle_notifications = document.querySelector('.toggle-notifications');

if (toggle_notifications) {
    toggle_notifications.addEventListener('click', function (e) {
        e.preventDefault();

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.responseText;

                if (res != 'ok') {
                    alert('A problem occured, please try again.');
                }
            }
        };
        xhttp.open('GET', '/api/notifications', true);
        xhttp.send();
    });
}

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

var dates_formatted = document.querySelectorAll('.date-formatted');

dates_formatted.forEach(function (date) {
    var date_date = date.innerHTML;
    date.innerHTML = moment(date_date).format('MMMM Do YYYY');
});