let upvote_buttons        = document.querySelectorAll('.comment-upvote')
let downvote_buttons      = document.querySelectorAll('.comment-downvote')
let misunderstand_buttons = document.querySelectorAll('.comment-misunderstand')
let comment_buttons       = document.querySelectorAll('.comment-comment')

upvote_buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault()

        let id = button.parentNode.getAttribute('data-id')

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

        let id = button.parentNode.getAttribute('data-id')

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

misunderstand_buttons.forEach((button) => {
    button.addEventListener('click', (e) => {
        e.preventDefault()

        let id = button.parentNode.getAttribute('data-id')

        let xhttp = new XMLHttpRequest()
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                let res = this.responseText

                if(res == 'Not connected') {
                    window.location.replace('/login')
                }

                else {
                    if(res != 'ok') {
                        alert('A problem occured, please try again.')
                    }
                }
            }
        }
        xhttp.open('GET', `/api/misunderstand/comments/${id}`, true)
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
        }

        else {
            parent.classList.remove('comment-reply-open')
            parent.nextSibling.remove()
        }
    })
})
