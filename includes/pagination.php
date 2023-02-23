<?php $base = strtok($_SERVER["REQUEST_URI"], '?'); ?>

<nav>
    
        <p>
            <?php if ($paginator->previous): ?>
                <a href="<?= $base; ?>?page=<?= $paginator->previous; ?>">Poprzednia</a>
            <?php else: ?>
                Poprzednia
            <?php endif; ?>
          
            <?php if ($paginator->next): ?>
                <a href="<?= $base; ?>?page=<?= $paginator->next; ?>">Następna</a>
            <?php else: ?>
                Następna
            <?php endif; ?>
        </p>
    
</nav>
