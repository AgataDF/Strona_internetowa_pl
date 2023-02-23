<?php

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

if (isset($_GET['id'])) {

    $article = Article::getByID($conn, $_GET['id']);

    if ( ! $article) {
        die("article not found");
    }

} else {
    die("id not supplied, article not found");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($article->delete($conn)) {

        Url::redirect("/admin/index.php");

    }
}

?>



<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - usuń artykuł</title>
    <link rel="stylesheet" href="/CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>
<h2>Na pewno chcesz usunąć artykuł?</h2>
<?php require '../includes/navigation.php'; ?>
    <main>

            <div class="article">
                
                <form method="post">
                        <button> Usuń </button>
                </form>
                <form method="post" action = "article.php?id=<?=$article->id; ?>">
                        <button> Wróć </button>
                </form>
                
            </div>
    </main>
    
    <?php require '../includes/jsscript.php'; ?>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>



