<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

if (isset($_GET['id'])) {
    $article = Article::getWithCategories($conn, $_GET['id']);
} else {
    $article = null;
}

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - artykuł</title>
    <link rel="stylesheet" href="/CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>

    <main>
            <div class="skill-row" style="text-align: center;">
            <?php if ($article) : ?>
    

                   <article>
                        <h2><?= $article[0]['title']; ?></h2>
                        <?php require '../includes/navigation.php'; ?>
                        <?php if ($article[0]['category_name']) : ?>
                            <p>Kategoria:
                                <?php foreach ($article as $a) : ?>
                                    <?= $a['category_name']; ?>
                                <?php endforeach; ?>
                            </p>
                        <?php endif; ?>

                        <p><?= $article[0]['content']; ?></p>
                    </article>

                    <a href="edit_article.php?id=<?= $article[0]['id']; ?>">Edytuj</a>
                    <br>
                    <a class="delete" href="delete_article.php?id=<?= $article[0]['id']; ?>">Usuń</a>
    
                    <?php else : ?>
                    <p>Article not found.</p>
                    <?php endif; ?>
            </div>
    </main>


    <?php require '../includes/jsscript.php'; ?>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>
