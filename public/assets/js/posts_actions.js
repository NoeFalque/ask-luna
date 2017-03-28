'use strict';

var upvote_buttons = document.querySelectorAll('.comment-upvote');
var comment_buttons = document.querySelectorAll('.comment-comment');

upvote_buttons.forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        var id = button.parentNode.getAttribute('data-id');

        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                button.parentNode.querySelector('.comment-score').innerHTML = this.responseText;
            }
        };
        xhttp.open('GET', '/api/upvote/comments/' + id, true);
        xhttp.send();
    });
});

comment_buttons.forEach(function (button) {
    button.addEventListener('click', function (e) {
        e.preventDefault();

        var parent = button.parentNode;
        var id = parent.getAttribute('data-id');

        if (!parent.classList.contains('comment-reply-open')) {
            parent.classList.add('comment-reply-open');

            console.log(parent);

            var element = document.createElement('div');
            element.classList.add('comment-reply-form');

            element.innerHTML = '\n                <div class="col-md-12">\n                    <form action="#" method="POST">\n                        <div class="form-group">\n                            <label for="answer">Help answering this question</label>\n                            <textarea name="answer" id="answer" class="form-control comment-reply-textarea" required autofocus></textarea>\n                            <input type="hidden" name="parent_id" value="' + id + '">\n                        </div>\n\n                        <div class="form-group">\n                            <button type="submit" class="btn btn-primary">Send my answer</button>\n                        </div>\n                    </form>\n                </div>\n            ';

            parent.parentNode.insertBefore(element, parent.nextSibling);

            var textarea = document.querySelector('.comment-reply-textarea');
            textarea.addEventListener('blur', function (element) {
                document.querySelector('.comment-reply-open').classList.remove('comment-reply-open');
                document.querySelector('.comment-reply-form').remove();
            });
        } else {
            document.querySelector('.comment-reply-open').classList.remove('comment-reply-open');
            document.querySelector('.comment-reply-form').remove();
        }
    });
});