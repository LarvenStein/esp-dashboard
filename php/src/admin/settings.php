<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <title>GBZ</title>
</head>
<body>
    <header>
        <a href="/"><img src="https://www.gartenbauzentrale.de/files/gbz/img/logo.svg"></a>
    </header>
    <main>
        <?php
            require_once ('../accsess.php');

            if($_POST['username'] == getAdminUser() && $_POST['password'] == getAdminPassword()) {
                echo '<h1>Admin Einstellungen</h1>';
                echo '<h2>Willkommen, ' . getAdminUser() . '</h2>';

                if(isset($_POST['DeviceName']) && isset($_POST['IP']) && isset($_POST['type']) && isset($_POST['DevicePassword'])) {
                    $Devices = [];
                    if(file_exists('../settings.json')) {
                        $Devices = json_decode(file_get_contents('../settings.json'), true);
                    }
                    $newDevice = [
                        'Name' => $_POST['DeviceName'],
                        'IP' => $_POST['IP'],
                        'Type' => $_POST['type'],
                        'Password' => base64_encode($_POST['DevicePassword']),
                        'RelayId' => $_POST['relay-id']
                    ];
                    array_push($Devices, $newDevice);
                    file_put_contents('../settings.json', json_encode($Devices, JSON_PRETTY_PRINT));

                    echo '
                    <div class="center">
                        <div class="newDevice">
                        <div class="center">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 0c6.623 0 12 5.377 12 12s-5.377 12-12 12-12-5.377-12-12 5.377-12 12-12zm0 1c6.071 0 11 4.929 11 11s-4.929 11-11 11-11-4.929-11-11 4.929-11 11-11zm7 7.457l-9.005 9.565-4.995-5.865.761-.649 4.271 5.016 8.24-8.752.728.685z"/></svg>
                        </div>
                        <h3>Das Gerät wurde Angelegt</h3>
                        <br>
                        '.$_POST['DeviceName'].',
                        '.$_POST['IP'].',
                        '.$_POST['type'].',
                        '.base64_encode($_POST['DevicePassword']).' <i>(Base64 enkodiert)</i>,
                        '.$_POST['relay-id'].'
                        <br><br>
                        <form method="post">
                        <input name="username" value="'.$_POST['username'].'" hidden>
                        <input name="password" value="'.$_POST['password'].'" hidden>
                        <input type="Submit" value="Zurück">
                        </form>
                        </div>
                        </div>
                    </div>
                    ';
                } elseif(isset($_POST['device2delete'])) { 
                    $current_Devices = json_decode(file_get_contents('../settings.json'));
                    echo '
                    <div class="center">
                        <div class="newDevice">
                        <div class="center">
                        <svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 0c6.623 0 12 5.377 12 12s-5.377 12-12 12-12-5.377-12-12 5.377-12 12-12zm0 1c6.071 0 11 4.929 11 11s-4.929 11-11 11-11-4.929-11-11 4.929-11 11-11zm7 7.457l-9.005 9.565-4.995-5.865.761-.649 4.271 5.016 8.24-8.752.728.685z"/></svg>
                        </div>
                        <h3>Das Gerät "'.$current_Devices[$_POST['device2delete']]->Name.'" wurde gelöscht.</h3>
                        <br><br>
                        <form method="post">
                        <input name="username" value="'.$_POST['username'].'" hidden>
                        <input name="password" value="'.$_POST['password'].'" hidden>
                        <input type="Submit" value="Zurück">
                        </form>
                        </div>
                        </div>
                    </div>
                    ';

                    unset($current_Devices[$_POST['device2delete']]);
                    file_put_contents('../settings.json', json_encode($current_Devices, JSON_PRETTY_PRINT));
                }else {
                    $current_Devices = json_decode(file_get_contents('../settings.json'));
                echo '
                <div class="center">
                <div class="newDevice">
                    <h3>Neues Gerät hinzufügen</h3>
                    <div class="setting">
                        <form method="post">
                            <input name="username" value="'.$_POST['username'].'" hidden>
                            <input name="password" value="'.$_POST['password'].'" hidden>

                            <label for="DeviceName">Gerätename</label><br>
                            <input type="text" name="DeviceName" requierd>
                            <br><br>
                            <label for="IP">IP-Adresse</label><br>
                            <input type="text" name="IP" requierd>
                            <br><br>
                            <label for="type">Gerätetyp</label><br>
                            <select name="type" style="width: 277px;">
                                <option>Auswählen</option>
                                <option value="gate">Tor / Schranke</option>
                                <option value="light">Licht</option>
                            </select>
                            <br><br>
                            <label for="DevicePassword">Geräte Passwort</label><br>
                            <input type="text" name="DevicePassword">
                            <br><br>
                            <label for="relay-id">Relay Nummer <a href="https://i.imgur.com/uTUvJ83.png" target="_blank">?</a><br> (Nur bei Multi-Relay ESPs eingeben)</label><br>
                            <input type="text" name="relay-id" placeholer="Klicke für Beispiel"> 
                            <br><br>
                            <button type="submit">Gerät Hinzufügen</button>
                        </form>
                    </div>
                </div>
                <br>
                <div class="newDevice">
                <h3>Gerät Löschen</h3>
                <div class="setting">
                    <form method="post">
                        <input name="username" value="'.$_POST['username'].'" hidden>
                        <input name="password" value="'.$_POST['password'].'" hidden>

                        <label for="device2delete">Zu löschenes Gerät</label><br>
                        <select name="device2delete">';
                        foreach($current_Devices as $index=>$curdev) {
                            echo '<option value="'.$index.'">'.$curdev->Name.' ('.$curdev->IP.')</option>';
                        }
                        echo '
                        </select>
                        <br><br>
                        <button type="submit">Gerät Löschen</button>
                    </form>
                </div>
                
                
                </div>
                ';
                }
            } else {
                die ('<h1>Falschs Passwort</h1><br>
                <a href="index.php" class="center">Zurück</a>
                ');
            }
        ?>
    </main>
</body>
</html>