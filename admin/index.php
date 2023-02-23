<?php 

require '../includes/init.php';

Auth::requireLogin();

$conn = require '../includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1, 6 , Article::getTotal($conn));
$articles = Article::getAll($conn);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Agata</title>
    <link rel="stylesheet" href="/CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>


<h2>Administracja</h2>
<?php require '../includes/navigation.php'; ?>
<p><a href="new_article.php">Dodaj artykuł</a></p>

<?php if (empty($articles)) : ?>
<p>Nie znaleziono artykułów</p>
<?php else : ?>

<table class="skill-row" style="text-align:center;">
    <thead>
        <th>Tytuł</th>
        <th>Opublikowano</th>
    </thead>
    <tbody>
        <?php foreach ($articles as $article) : ?>
            <tr>
                <td>
                    <a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a>
                </td>
                <td>
                    <?php if ($article['published_at']) : ?>
                        <time><?= $article['published_at'] ?></time>
                    <?php else : ?>
                        Nieopublikowano
                        <button class="publish" data-id="<?= $article['id'] ?>">Publikuj</button>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require '../includes/pagination.php'; ?>

<?php endif; ?>

<?php require '../includes/jsscript.php'; ?>

<footer class="bottom_container">
  <p class="copyright">© Agata Dziuba-Flizikowska</p>
</footer>

</body>
</html>