<?php

require 'includes/database.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {

    $sql = "SELECT *
            FROM artykul
            WHERE id = " . $_GET['id'];

    $results = mysqli_query($conn, $sql);

    if ($results === false) {

        echo mysqli_error($conn);

    } else {

        $article = mysqli_fetch_assoc($results);

    }

} else {
    $article = null;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - artykuł</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>
    <main class="middle_container">
        <div class="artykul">
            <div class="skill-row" style="text-align: center;">
                <?php if ($article === null): ?>
                    <p>Article not found.</p>
                <?php else: ?>
                <article>
                    <h2><?= $article['title']; ?></h2>
                    <hr>
                    <p><?= $article['content']; ?></p>
                </article>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>
