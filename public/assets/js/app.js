'use strict';

var toggle_notifications = document.querySelector('.toggle-notifications');

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