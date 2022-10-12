function togglegate(vv) {

    // Wenn eine Anfrage aus den PHP skripten kommt, gebe sie an die API weiter

    // Das ist so ähnlich wie CURL in PHP
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '../api.php?action=toggle&device=' + vv);

    xhr.responseType = 'json';

    xhr.send();

    // Wenn die von der API kommt...
    xhr.onload = function() {
    let responseObj = xhr.response;

    //... Prüfe die Antwort ...
        if(responseObj.status == 'fail') {
            // ... Wenn diese Fehlgeschlagen wird, zeige es den Nutzer an
            document.getElementById('status').classList.add('alert');
            document.getElementById('status').textContent = 'Fehler: ' + responseObj.information;
    
        } else {
            // Wenn die Anfrage funktionuert hat, führe ✨Animationen✨ aus

            document.getElementById('gatebox').classList.add('sucsess');
    
            setTimeout(rmsucsess, 4000);
        
            function rmsucsess() {
                document.getElementById('gatebox').classList.remove('sucsess');
            }
        
            if(document.getElementById('main').classList.contains('light')) {
                document.getElementById('main').classList.remove('light');
                document.getElementById('btn').classList.remove('light');
            } else {
                document.getElementById('main').classList.add('light');
                document.getElementById('btn').classList.add('light');
            }
        }

    };
}

// Hier wird eine Prüfungsanfrage gesendet um zu sehen ob ein licht an ist
function checklight(vv) {

    // Das gleihe CURL ähnliche Spiel wie vorher
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '../api.php?action=check&check=light&device=' + vv); 

    xhr.responseType = 'json';

    xhr.send();

    xhr.onload = function() {
    let responseObj = xhr.response;

        if(responseObj.POWER == 'ON') {
            // Wenn das licht an ist, führe ✨Kosmetische Änderungen✨ auf der seite aus: Der hintergrund wird weiß

            document.getElementById('main').classList.add('light');
            document.getElementById('btn').classList.add('light');
    
        }
    };
}