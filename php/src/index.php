<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet">
    <title>GBZ</title>
</head>
<body>
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
    <header>
    <a href="/"><img src="https://www.gartenbauzentrale.de/files/gbz/img/logo.svg"></a>
    </header>
    <a href="admin/"><svg style="position:absolute; top: 5px; right: 5px; background: #383837; border-radius: 50%;" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm0 22c-3.123 0-5.914-1.441-7.749-3.69.259-.588.783-.995 1.867-1.246 2.244-.518 4.459-.981 3.393-2.945-3.155-5.82-.899-9.119 2.489-9.119 3.322 0 5.634 3.177 2.489 9.119-1.035 1.952 1.1 2.416 3.393 2.945 1.082.25 1.61.655 1.871 1.241-1.836 2.253-4.628 3.695-7.753 3.695z"/></svg></a>
    <h1>Geräte</h1>
    <main class="home">
        <?php
            $devices = json_decode(file_get_contents('settings.json'));

            foreach($devices as $index=>$device) {
                echo '
                <a class="device" href="device/'.$device->Type.'.php?device='.$index.'">
                    '. file_get_contents('media/'.$device->Type.'.svg').'<br>
                    <b>'.$device->Name.'</b>
                    <p>'.$device->Type.'</p>
                </a>
                ';
            }
        ?>
    </main>
</body>
</html>