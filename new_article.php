<?php



if ($_SERVER["REQUEST_METHOD"] == "POST"){

    require 'includes/database.php';

    $sql = "INSERT INTO artykul (title, content, published_at)
            VALUES (?, ?, ?)";

    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {

        echo mysqli_error($conn);

    } else {

        mysqli_stmt_bind_param($stmt,"sss", $_POST['title'], $_POST['content'], $_POST['published_at']);

        if (mysqli_stmt_execute($stmt)){
            $id = mysqli_insert_id($conn);
        } else {
            echo msqli_stmt_error($stmt);
        }
    }
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
        <div class="new-article">
            <div class="skill-row" style="text-align: center;">
                <h2>Dodaj nowy artykuł</h2>
                <form method="post">
                    <div>
                    <label for="title">Tytuł</label>
                    <input type="text" name="title" id="title" placeholder="Tytuł artykułu">
                    </div>

                    <div>
                    <label for="content">Treść artykułu</label>
                    <textarea type="text" name="content" rows="4" cols="40" id="content" placeholder="Treść artykułu"></textarea>
                    </div>

                    <div>
                    <label for="published_at">Data publikacji</label>
                    <input type="date" name="published_at" id="published_at">
                    </div>

                    <button>Dodaj</button>

                </form>



                <!-- <?php if ($article === null): ?>
                    <p>Article not found.</p>
                <?php else: ?>
                <article>
                    <h2><?= $article['title']; ?></h2>
                    <hr>
                    <p><?= $article['content']; ?></p>
                </article>
                <?php endif; ?> -->
            </div>
        </div>
    </main>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>
