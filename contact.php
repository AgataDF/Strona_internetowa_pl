<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer-master/src/Exception.php';
require 'vendor/PHPMailer-master/src/PHPMailer.php';
require 'vendor/PHPMailer-master/src/SMTP.php';

require 'includes/init.php';

$email = '';
$subject = '';
$message = '';
$sent = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $errors = [];

    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $errors[] = 'Wpisz poprawny adres email';
    }

    if ($subject == '') {
        $errors[] = 'Wpisz tytuł';
    }

    if ($message == '') {
        $errors[] = 'Wpisz wiadomość';
    }

    if (empty($errors)) {

        $mail = new PHPMailer(true);

        try {

            $mail->isSMTP();
            $mail->Host = SMTP_HOST;
            $mail->SMTPAuth = true;
            $mail->Username = SMTP_USER;
            $mail->Password = SMTP_PASS;
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('sender@example.com');
            $mail->addAddress(SMTP_USER);
            $mail->addReplyTo($email);
            $mail->Subject = $subject;
            $mail->Body = $message;

            $mail->send();

            $sent = true;

        } catch (Exception $e) {

            $errors[] = $mail->ErrorInfo;

        }
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
    <h2>Kontakt</h2>

    <?php if ($sent) : ?>
        <p>Wiadomość wysłana.</p>
    <?php else: ?>
    
        <?php if (! empty($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>
    
        <form method="post" id="formContact">
    
            <div class="form-group">
                <label for="email">Twój email</label>
                <input class="form-control" name="email" id="email" type="email" value="<?= htmlspecialchars($email) ?>">
            </div>
                    <br>
            <div class="form-group">
                <label for="subject">Temat</label>
                <input class="form-control" name="subject" id="subject"  value="<?= htmlspecialchars($subject) ?>">
            </div>
                    <br>
            <div class="form-group">
                <label for="message">Wiadomość</label>
                <textarea class="form-control" name="message" id="message" ><?= htmlspecialchars($message) ?></textarea>
            </div>
                    <br>
            <button class="btn">Wyślij</button>
    
        </form>
    
    <?php endif; ?>
    </main>

    <?php require 'includes/jsscript.php'; ?>

    <footer class="bottom_container">
        <p class="copyright">© Agata Dziuba-Flizikowska</p>
    </footer>
</body>

