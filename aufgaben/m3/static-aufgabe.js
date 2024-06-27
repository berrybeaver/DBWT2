window.onload = function() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../public/static/message.json', true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                var messageElement = document.getElementById('message-container');
                if (messageElement) {
                    messageElement.innerText = response.message;
                }
            } else {
                console.error('Fehler beim Laden der Nachricht: ' + xhr.status);
            }
        }
    };
    xhr.send();
};
