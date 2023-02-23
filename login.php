<?php

require 'includes/init.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $conn = require 'includes/db.php';

    if (User::authenticate($conn, $_POST['username'], $_POST['password'])) {

        Auth::login();

        Url::redirect('/');

    } else {

        $error = "Niepoprawny login lub hasło";

    }
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Logowanie</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>
    <main class="middle_container">
        <div class="new-article">
            <div class="skill-row" style="text-align: center;">
                <h2>Login</h2>

                <?php if (! empty($error)) : ?>
                    <p><?= $error ?></p>
                <?php endif; ?>

                <form method="post">

                    <div>
                        <label for="username">Nazwa użytkownika</label>
                        <input name="username" id="username">
                    </div>

                    <div>
                        <label for="password">Hasło</label>
                        <input type="password" name="password" id="password">
                    </div>

                    <button>Zaloguj</button>

                </form>
            </div>
        </div>
    </main>

    <?php require 'includes/jsscript.php'; ?>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>
