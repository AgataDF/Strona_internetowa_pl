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

$category_ids = array_column($article->getCategories($conn), 'id');

$categories = Category::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    $category_ids = $_POST['category'] ?? [];

    if ($article->update($conn)) {

        $article->setCategories($conn, $category_ids);

        Url::redirect("/admin/article.php?id={$article->id}");

    }
}

?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - edytuj artykuł</title>
    <link rel="stylesheet" href="/CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>
<h2>Edytuj artykuł</h2>
<?php require '../includes/navigation.php'; ?>

    <main>
            <div class="skill-row" style="text-align: center;">
                
                <?php require 'includes/article-form.php'; ?>
                
            </div>
    </main>

    <?php require '../includes/jsscript.php'; ?>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>