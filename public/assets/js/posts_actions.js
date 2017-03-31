'use strict';

var upvote_buttons = document.querySelectorAll('.comment-upvote');
var downvote_buttons = document.querySelectorAll('.comment-downvote');
var comment_buttons = document.querySelectorAll('.comment-comment');

upvote_buttons.forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        var id = button.getAttribute('data-id');

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.responseText;

                if (res == 'Not connected') {
                    window.location.replace('/login');
                } else {
                    if (!isNaN(parseInt(res))) {
                        button.parentNode.querySelector('.comment-score').innerHTML = this.responseText;
                    } else {
                        console.log(res);
                        alert('A problem occured, please try again.');
                    }
                }
            }
        };
        xhttp.open('GET', '/api/upvote/comments/' + id, true);
        xhttp.send();
    });
});

downvote_buttons.forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        var id = button.getAttribute('data-id');

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var res = this.responseText;

                if (res == 'Not connected') {
                    window.location.replace('/login');
                } else {
                    if (!isNaN(parseInt(res))) {
                        button.parentNode.querySelector('.comment-score').innerHTML = this.responseText;
                    } else {
                        alert('A problem occured, please try again.');
                    }
                }
            }
        };
        xhttp.open('GET', '/api/downvote/comments/' + id, true);
        xhttp.send();
    });
});

comment_buttons.forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        var parent = button.parentNode;
        var id = button.getAttribute('data-id');

        parent = parent.parentNode.parentNode;

        if (!parent.classList.contains('comment-reply-open')) {
            parent.classList.add('comment-reply-open');

            var element = document.createElement('div');
            element.classList.add('comment-reply-form');

            element.innerHTML = '\n                <form action="#" method="POST">\n                    <textarea name="answer" id="answer" class="form-control comment-reply-textarea" required autofocus></textarea>\n                    <input type="hidden" name="parent_id" value="' + id + '">\n                    <button type="submit" class="btn btn-primary">Send</button>\n                </form>\n            ';
            parent.parentNode.insertBefore(element, parent.nextSibling);
        } else {
            parent.classList.remove('comment-reply-open');
            parent.nextSibling.remove();
        }
    });
});