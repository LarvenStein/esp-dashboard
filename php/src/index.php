<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>GBZ</title>
    <script src="device/opengate.js" defer></script>
</head>
<body>
    <?php
    error_reporting(0);
        require_once('accsess.php');

        // Passwortprüfung

        if(isset($_COOKIE['pw'])) {
            // Wenn das passwort schon in Cookies gespeichert ist:
            $password = base64_decode($_COOKIE['pw']);
        } elseif(isset($_POST['pw'])) {
            // Wenn das Passwort über das formular und POST gesendet wurde
            $password = $_POST['pw'];
        } else {
            // wenn keine Passworteingabe vorhanden ist
            $password = null;
        }
        // Ist das Passwort Richtig?
        if($password == getUserPassword()) {
            // Richtiges Passwort: In Base64 enkodieren und in Cookies speichern 
            echo '<script>
                document.cookie = "pw='.base64_encode($password).'; max-age=max-age-in-seconds=31536000";
            </script>';
        } else {
            // Wenn das Passwort falsch ist, stoppe alle Prozesse und zeige das Anmeldeformular

            die('
            <form method="post" class="newDevice absolutecenter">
            <h1>Bitte Einloggen!</h1>
            <input type="password" name="pw" placeholder="Passwort" required>
            <br>
            <button type="submit">Login</button>
        </form>
            ');
        }
    ?>
    <!--Der HTML Header mit Gemüse und GBZ Logo-->
    <header>
    <a href="/"><img src="https://www.gartenbauzentrale.de/files/gbz/img/logo.svg"></a>
    </header>
    <a href="admin/"><svg style="position:absolute; top: 5px; right: 5px; background: #383837; border-radius: 50%;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 22c-3.123 0-5.914-1.441-7.749-3.69.259-.588.783-.995 1.867-1.246 2.244-.518 4.459-.981 3.393-2.945-3.155-5.82-.899-9.119 2.489-9.119 3.322 0 5.634 3.177 2.489 9.119-1.035 1.952 1.1 2.416 3.393 2.945 1.082.25 1.61.655 1.871 1.241-1.836 2.253-4.628 3.695-7.753 3.695z"/></svg></a>
    <h1>Geräte</h1>
    <main class="home">
        <?php
        // Hole liste aller Gräte und Dekodiere das JSON Arraay in ein PHP Array
            $devices = json_decode(file_get_contents('settings.json'));

            // Für jedes Gerätauf der Liste, zeige das an
            foreach($devices as $index=>$device) {
                echo '
                <div class="device">
                <a href="device/'.$device->Type.'.php?device='.$index.'" class="cwhite">
                    '. file_get_contents('media/'.$device->Type.'.svg').'<br>
                    <b>'.$device->Name.'</b>
                    </a>
                    <button class="" onclick="togglegate(&#39;'.$index.'&#39;)">Toggle</button> <!--Wenn der Butten angeklickt wird, führe diese JS funktion aus-->
                </div>
                ';
            }
        ?>
    </main>
</body>
</html>
