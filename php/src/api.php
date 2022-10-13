<?php
error_reporting(0);

    require_once('accsess.php');

    if(isset($_COOKIE['pw'])) {
        $password = base64_decode($_COOKIE['pw']);
    } elseif(isset($_POST['pw'])) {
        $password = $_POST['pw'];
    } else {
        $password = null;
    }
    if($password == getUserPassword()) {
        setcookie('pw', base64_encode($password), time() + (86400 * 365), "/");
    } else {
        // Hier wird bei einem Falschen passwort anstatt eines Formulars ein uauthorized angezeigt
        die('uauthorized');
    }

header('Content-Type: application/json; charset=utf-8');

// Hole aktuelle Liste an Geräten
$device_data = json_decode(file_get_contents('settings.json'));
//Suche gerät aus der Liste
$device = $device_data->{$_GET['device']};


if(strlen($_GET['action'] > 0)) {
    // Wenn Etwas umgeschaltet (getogglet) werden soll: z.b. Eine Garage 
    if($_GET['action'] == 'toggle') {

        // Starte die CURL anfrage auf die API des ESP
    if(strlen($device->RelayId > 0)){
        $ch = curl_init('http://' . $device->IP . '/cm?cmnd=POWER'.$device->RelayId.'+TOGGLE');
    } else {
        $ch = curl_init('http://' . $device->IP . '/cm?cmnd=POWER+TOGGLE');
    }
    //ESP username.
    $username = 'admin';
    //ESP password.
    $password = base64_decode($device->Password);
    //Füge Header zu der Anfrage hinzu
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic '. base64_encode("$username:$password")
    );
    //Sende die CURL anfrage
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $curlresponse = curl_exec($ch);

    if(curl_errno($ch)) {
        // Bei fehlern der Anfrage Antworte das:
        $response = [
            "status" => "fail",
            "information" => "Fehler bei der Kommunikation mit dem Gerät ".$device->Name." (".$device->IP.")"
        ];
    } else {
        // Wenn alles Funktioneirt, bestätige den Erfolg
        $response = [
            "status" => "success"
        ];
    }

    }

    // Bei einem Licht wird hier nachgeschaut ob die Lampe schon an ist
    if($_GET['action'] == 'check') {
        if($_GET['check'] == 'light') {
            // Hier wird wieder CURL verwendet
            $ch = curl_init('http://' . $device->IP . '/cm?cmnd=POWER+TOGGLE');
            //ESP username.
            $username = 'admin';
            //Esp   password.
            $password = base64_decode($device->Password);
            //Füge Header hinzu
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic '. base64_encode("$username:$password")
            );
            
            // Weil Tasmota nicht sagen kann ob ein Relay an ist, nehme ich einen umweg.
            // Ich sende die Anfrage zwei mal und sehe in der 2. Antwort den Status des Relays.
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, 'http://' . $device->IP . '/cm?cmnd=POWER+TOGGLE');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
            curl_exec($ch);
            $response = json_decode(curl_exec($ch));
            curl_close($ch); 
        
            if(curl_errno($ch)) {
                        // Bei fehlern der Anfrage Antworte das:
                $response = [
                    "status" => "fail",
                    "information" => "Fehler bei der Kommunikation mit dem Gerät ".$device->Name." (".$device->IP.")"
                ];
            } 
        }
    }

} else {
    // Wenn nicht spezifiziert wird, was getan werden soll, gebe diese Fehlermeldung aus.
    $response = [
        "status" => "fail",
        "information" => "Gerät oder Aktion nicht gesetzt!"
    ];
}

// Enkodiere die Antworten in ein JSON Array und gebe es aus

echo json_encode($response);