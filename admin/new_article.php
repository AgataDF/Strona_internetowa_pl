<?php

require '../includes/init.php';

Auth::requireLogin();

$article = new Article();

$category_ids = [];

$conn = require '../includes/db.php';

$categories = Category::getAll($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $article->title = $_POST['title'];
    $article->content = $_POST['content'];
    $article->published_at = $_POST['published_at'];

    $category_ids = $_POST['category'] ?? [];

    if ($article->create($conn)) {

        $article->setCategories($conn, $category_ids);

        Url::redirect("/admin/article.php?id={$article->id}");

    }
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Portfolio - dodaj nowy artykuł</title>
    <link rel="stylesheet" href="/CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>
<h2>Dodaj nowy artykuł</h2>    
<?php require '../includes/navigation.php'; ?>
    <main class="article">
            
                
         <?php require 'includes/article-form.php'; ?>
                
           
    </main>

    <?php require '../includes/jsscript.php'; ?>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>
