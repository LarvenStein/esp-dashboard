<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="../style.css" rel="stylesheet">
    <title>GBZ</title>
    <script src="opengate.js" defer></script>
</head>
<?php
error_reporting(0);

        require_once('../accsess.php');

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
            die('
            <form method="post" class="newDevice allcenter">
            <h1>Bitte Einloggen!</h1>
            <input type="password" name="pw" placeholder="Passwort" required>
            <br>
            <button type="submit">Login</button>
        </form>
            ');
        }
    ?>
<?php 
echo '
<body id="main" onload="checklight(&#39;'.$_GET['device'].'&#39;)">
';
?>
    <header>
        <a href="/"><img src="https://www.gartenbauzentrale.de/files/gbz/img/logo.svg"></a>
    </header>
    <main class="devicebody allcenter">
        <?php
            $device_data = json_decode(file_get_contents('../settings.json'));
            $device = $device_data[$_GET['device']];

            if($device->Type == 'light') {
                // Hier Code zum Abrufen des Status einfügen
                
                echo '
                <div class="allcenter devicepanel" id="btn">
                <div>
                    <h1>'.$device->Name.'</h1>
                    <button class="" onclick="togglegate(&#39;'.$_GET['device'].'&#39;)">Toggle</button>
                    <p id="status" class="hidden"></p>
                </div>
                </div>
                ';

            } else {
                echo '
                <div class="allcenter devicepanel">
                <div>
                <h1>Hier ist etwas schief gelaufen!</h1>
                <a href="'.$device->Type.'.php?device='.$_GET['device'].'">Zum richtigen Gerät >></a>
                </div>
                </div>';
                http_response_code(404);
            }
        ?>
    </main>
</body>
</html>