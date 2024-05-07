window.onload = function() {
    // Funktion, um die Nachricht abzurufen und darzustellen
    function fetchMessage() {
        let xhr = new XMLHttpRequest();
        xhr.open('GET', '../public/static/message.json', true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState === XMLHttpRequest.DONE) {
                if (xhr.status === 200) {
                    let response = JSON.parse(xhr.responseText);
                    let messageElement = document.getElementById('message');
                    if (messageElement) {
                        messageElement.innerText = response.message;
                    }
                } else {
                    console.error('Fehler beim Laden der Nachricht: ' + xhr.status);
                }
            }
        };
        xhr.send();
    }

    // Zuerst die Nachricht abrufen
    fetchMessage();

    // Zyklisch alle 3 Sekunden die Nachricht aktualisieren
    setInterval(fetchMessage, 3000);
};
