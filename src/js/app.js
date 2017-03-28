let toggle_notifications = document.querySelector('.toggle-notifications')

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
