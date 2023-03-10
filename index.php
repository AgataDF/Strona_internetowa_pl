<?php 

require 'includes/init.php';

$conn = require 'includes/db.php';

$paginator = new Paginator($_GET['page'] ?? 1, 4, Article::getTotal($conn, true));

$articles = Article::getPage($conn, $paginator->limit, $paginator->offset, true);

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Agata</title>
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="icon" href="favicon.ico ">
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin><link href="https://fonts.googleapis.com/css2?family=Merriweather&family=Montserrat&family=Sacramento&display=swap" rel="stylesheet">

</head>
<body>
    <header class="top_container">
        <img class ="top-cloud" src="images/cloud.png" alt="cloud-img">
        <h1>Cześć, jestem Agata</h1>
        <h2>inżynier elektroenergetyki</h2>
        <img class ="bottom-cloud" src="images/cloud.png" alt="cloud-img">
</header>
  <main class="middle_container">
    <div class="profile">
        <img class ="profile-img" src="images/girld.png" alt="avatar-by-Victoruler">
        <div class="profile-row">
          <h2>O mnie</h2>
          <p>Obecnie jestem asystentką projektanta instalacji elektrycznych i teletechnicznych. Kształcę się jako programistka w ramach kursu <i>Elitarny Projekt "Przyszły Programista"</i>.</p>
        </div>
    </div>

    <hr>

    <div class="skills">
      <h2>Umiejętności</h2>
      <div class="skill-row">
        <img class="icon-img" src="images/lightbulb.png" alt="lightbulb-by-juicy_fish">
        <h3>Programy inżynierskie</h3>
        <p>W zaawansowanym stopniu potrafię posługiwać się programami jak AutoCAD, DIALux, PVSol.</p>
      </div>
      <div class="skill-row">
        <img class="icon-img" src="images/c-.png" alt="c++-sign-by-Freepik">
        <h3>C++</h3>
        <p>Potrafię programować w języku C++.</p>
      </div>
    </div>

    <hr>

    <div class="portfolio">
      <h2>Portfolio</h2>
      
      <?php require 'includes/navigation.php'; ?>

      
      <?php if (empty($articles)): ?>
        <p>Nie znaleziono artykułów.</p>
            
      <?php else: ?>
        
        <?php foreach ($articles as $article): ?>
          
          <article class="skill-row">
            <h3><a href="article.php?id=<?= $article['id']; ?>"><?= htmlspecialchars($article['title']); ?></a></h3>

            <time datetime="<?= $article['published_at'] ?>"><?php
                        $datetime = new DateTime($article['published_at']);
                        echo $datetime->format("j.m.Y");
                    ?></time>

            <?php if ($article['category_names']) : ?>
                <p>Kategoria:
                    <?php foreach ($article['category_names'] as $name) : ?>
                        <?= htmlspecialchars($name); ?>
                    <?php endforeach; ?>
                <p>
            <?php endif; ?>

            <p><?= $article['content']; ?></p>
          </article>
          
        <?php endforeach; ?>
        <?php require 'includes/pagination.php'; ?>

      <?php endif; ?>
    </div>
    
    <hr>

    <div class="contact-me">
      <h2>Kontakt</h2>
      <h3 class="contact-text-h3"> ⬇ Jeśli masz jakieś pytania ⬇ </h3>
      <a class="btn" href="/contact.php">Skontaktuj się</a>
    </div>
  </main>

  <?php require 'includes/jsscript.php'; ?>

<footer class="bottom_container">
  <p class="copyright">© Agata Dziuba-Flizikowska</p>
</footer>

</body>
</html>