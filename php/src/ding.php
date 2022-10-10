<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="5">
    <style>
        body {
            margin: 0;
            display: flex;
            text-align: center;
            justify-content: center;
            font-size: 24pt;
        }
        .alert {
            height: 100vh;
            animation: alert 2.5s infinite;
        }
        .temp {
            width: 50%;
            height: 100%;
        }

        @keyframes alert {
            0% {
                color: black;
                background: white;
            }
            50% {
                color: white;
                background: red;
            }
            100% {
                color: black;
                background: white;
            }
        }
        .bg {
            background: aqua;
            width: 50%;
            position: absolute;
        }
        .luftfeuchtigkeit {
            width: 50%;
            height: 100%;
        }
    </style>
</head>
<body>
<div class="temp">
<?php

$baseinfo = json_decode(file_get_contents('http://192.168.99.121/cm?cmnd=STATUS+8'));

$temp = $baseinfo->StatusSNS->DHT11->Temperature;
$humidity = $baseinfo->StatusSNS->DHT11->Humidity;

if($temp > '2.9') {
    echo '<div class="alert">
    Aktuelle Temperatur:<br> ' . $temp . '°C<br></div>';

    $power = json_decode(file_get_contents('http://192.168.99.121/cm?cmnd=POWER+ON'));
} else {
    echo 'Aktuelle Temperatur:<br> ' . $temp . '°C<br>';

    $power = json_decode(file_get_contents('http://192.168.99.121/cm?cmnd=POWER+OFF'));
}


echo '
</div>
<div class="luftfeuchtigkeit">
    <div class="bg" style="height: '.$humidity.'%; top: calc(100% - '.$humidity.'%)"></div>
    <div style="z-index: 99">
    Luftfeuchtigkeit:<br>
    '.$humidity.'%
    </div>
</div>
';
?>
</body>
</html>