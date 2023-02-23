<nav>

    
    <?php if (Auth::isLoggedIn()) : ?>

        <p><a href="/">Home</a>
        <a href="/admin/">Admin</a>
        <a href="/logout.php">Wyloguj</a></p>

    <?php else : ?>

        <p><a href="/login.php">Zaloguj</a></p>

    <?php endif; ?>

</nav>