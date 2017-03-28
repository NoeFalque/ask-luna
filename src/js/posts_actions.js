let upvote_buttons  = document.querySelectorAll('.comment-upvote')
let comment_buttons = document.querySelectorAll('.comment-comment')

upvote_buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault()

        let id = button.parentNode.getAttribute('data-id')

        let xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                button.parentNode.querySelector('.comment-score').innerHTML = this.responseText
            }
        }
        xhttp.open('GET', `/api/upvote/comments/${id}`, true)
        xhttp.send()
    })
})

comment_buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault()

        let parent = button.parentNode
        let id     = parent.getAttribute('data-id')

        if(!parent.classList.contains('comment-reply-open')) {
            parent.classList.add('comment-reply-open')

            console.log(parent)

            let element = document.createElement('div')
            element.classList.add('comment-reply-form')

            element.innerHTML = `
                <div class="col-md-12">
                    <form action="#" method="POST">
                        <div class="form-group">
                            <label for="answer">Help answering this question</label>
                            <textarea name="answer" id="answer" class="form-control comment-reply-textarea" required autofocus></textarea>
                            <input type="hidden" name="parent_id" value="${id}">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Send my answer</button>
                        </div>
                    </form>
                </div>
            `

            parent.parentNode.insertBefore(element, parent.nextSibling)

            let textarea = document.querySelector('.comment-reply-textarea')
            textarea.addEventListener('blur', (element) => {
                document.querySelector('.comment-reply-open').classList.remove('comment-reply-open')
                document.querySelector('.comment-reply-form').remove()
            })
        }

        else {
            document.querySelector('.comment-reply-open').classList.remove('comment-reply-open')
            document.querySelector('.comment-reply-form').remove()
        }
    })
})
