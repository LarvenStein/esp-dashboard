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
        <h1>Admin Login</h1>
        <form method="post" action="settings.php">
            <input type="user" name="username" placeholder="Nutzername" required>
            <br>
            <input type="password" name="password" placeholder="Passwort" required>
            <br>
            <button type="submit">Login</button>
        </form>
    </main>
</body>
</html>