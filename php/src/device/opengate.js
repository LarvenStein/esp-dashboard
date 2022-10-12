function togglegate(vv) {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '../api.php?action=toggle&device=' + vv);

    xhr.responseType = 'json';

    xhr.send();

    xhr.onload = function() {
    let responseObj = xhr.response;

        if(responseObj.status == 'fail') {

            document.getElementById('status').classList.add('alert');
            document.getElementById('status').textContent = 'Fehler: ' + responseObj.information;
    
        }

    };

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
function checklight(vv) {
    let xhr = new XMLHttpRequest();

    xhr.open('GET', '../api.php?action=check&check=light&device=' + vv); // "check=light" gegen namen aus Statusantwort austauschen (wie z.b. Humidity)

    xhr.responseType = 'json';

    xhr.send();

    xhr.onload = function() {
    let responseObj = xhr.response;

        if(responseObj.POWER == 'ON') {

            document.getElementById('main').classList.add('light');
            document.getElementById('btn').classList.add('light');
    
        }
    };
}