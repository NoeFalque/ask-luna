let upvote_buttons        = document.querySelectorAll('.comment-upvote')
let downvote_buttons      = document.querySelectorAll('.comment-downvote')
let comment_buttons       = document.querySelectorAll('.comment-comment')

upvote_buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault()

        let id = button.getAttribute('data-id')

        let xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText

                if(res == 'Not connected') {
                    window.location.replace('/login')
                }

                else {
                    if(!isNaN(parseInt(res))) {
                        button.parentNode.querySelector('.comment-score').innerHTML = this.responseText
                    }

                    else {
                        console.log(res)
                        alert('A problem occured, please try again.')
                    }
                }
            }
        }
        xhttp.open('GET', `/api/upvote/comments/${id}`, true)
        xhttp.send()
    })
})

downvote_buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault()

        let id = button.getAttribute('data-id')

        let xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText

                if(res == 'Not connected') {
                    window.location.replace('/login')
                }

                else {
                    if(!isNaN(parseInt(res))) {
                        button.parentNode.querySelector('.comment-score').innerHTML = this.responseText
                    }

                    else {
                        alert('A problem occured, please try again.')
                    }
                }
            }
        }
        xhttp.open('GET', `/api/downvote/comments/${id}`, true)
        xhttp.send()
    })
})

comment_buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault()

        let parent = button.parentNode
        let id     = button.getAttribute('data-id')

        parent = parent.parentNode.parentNode

        if(!parent.classList.contains('comment-reply-open')) {
            parent.classList.add('comment-reply-open')

            let element = document.createElement('div')
            element.classList.add('comment-reply-form')

            element.innerHTML = `
                <form action="#" method="POST">
                    <input type="text" name="answer" id="answer" class="form-control comment-reply-textarea" required autofocus>
                    <input type="hidden" name="parent_id" value="${id}">
                    <button type="submit" class="btn btn-primary">Send</button>
                </form>
            `
            parent.parentNode.insertBefore(element, parent.nextSibling)
        }

        else {
            parent.classList.remove('comment-reply-open')
            parent.nextSibling.remove()
        }
    })
})
