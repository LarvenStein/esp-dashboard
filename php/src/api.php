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
        die('uauthorized');
    }

header('Content-Type: application/json; charset=utf-8');

$device_data = json_decode(file_get_contents('settings.json'));
$device = $device_data[$_GET['device']];


if(strlen($_GET['action'] > 0)) {


    // Wenn Etwas umgeschaltet (getogglet) werden soll: z.b. Eine Garage 
    if($_GET['action'] == 'toggle') {

    $ch = curl_init('http://' . $device->IP . '/cm?cmnd=POWER+TOGGLE');
    //HTTP username.
    $username = 'admin';
    //HTTP password.
    $password = base64_decode($device->Password);
    //Create the headers array.
    $headers = array(
        'Content-Type: application/json',
        'Authorization: Basic '. base64_encode("$username:$password")
    );
    //Set the headers that we want our cURL client to use.
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $curlresponse = curl_exec($ch);

    if(curl_errno($ch)) {
        $response = [
            "status" => "fail",
            "information" => "Fehler bei der Kommunikation mit dem Gerät ".$device->Name." (".$device->IP.")"
        ];
    } else {
        $response = [
            "status" => "success"
        ];
    }

    }

    if($_GET['action'] == 'check') {
        if($_GET['check'] == 'light') {
            $ch = curl_init('http://' . $device->IP . '/cm?cmnd=POWER+TOGGLE');
            //HTTP username.
            $username = 'admin';
            //HTTP password.
            $password = base64_decode($device->Password);
            //Create the headers array.
            $headers = array(
                'Content-Type: application/json',
                'Authorization: Basic '. base64_encode("$username:$password")
            );
            //Set the headers that we want our cURL client to use.
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_URL, 'http://' . $device->IP . '/cm?cmnd=POWER+TOGGLE');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
            curl_exec($ch);
            $response = json_decode(curl_exec($ch));
            curl_close($ch); 
        
            if(curl_errno($ch)) {
                $response = [
                    "status" => "fail",
                    "information" => "Fehler bei der Kommunikation mit dem Gerät ".$device->Name." (".$device->IP.")"
                ];
            } else {

            }
        }
    }

} else {
    $response = [
        "status" => "fail",
        "information" => "Gerät oder Aktion nicht gesetzt!"
    ];
}

echo json_encode($response);