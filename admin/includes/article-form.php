<?php if (! empty($article->errors)) : ?>
    
        <?php foreach ($article->errors as $error) : ?>
            <li><?= $error ?></li>    
        <?php endforeach; ?>
    
<?php endif; ?>
<br>
<form method="post" id="formArticle">

    <div>
        <label for="title">Tytuł</label>
        <input name="title" id="title" placeholder="Tytuł artykułu" value="<?= htmlspecialchars($article->title); ?>">
    </div>
<br>
    <div>
        <label for="content">Treść artykułu</label>
        <textarea name="content" rows="4" cols="40" id="content" placeholder="Treść artykułu"><?= htmlspecialchars($article->content); ?></textarea>
    </div>
<br>
    <div>
        <label for="published_at">Data publikacji</label>
        <input type="date" name="published_at" id="published_at" value="<?= htmlspecialchars($article->published_at); ?>">
    </div>
<br>
    <fieldset style = "border: none;">
        <legend>Kategorie</legend>

        <?php foreach ($categories as $category) : ?>
            <div>
                <input type="checkbox" name="category[]" value="<?= $category['id'] ?>" id="category<?= $category['id'] ?>"
                       <?php if (in_array($category['id'], $category_ids)) :?>checked<?php endif; ?>>
                <label for="category<?= $category['id'] ?>"><?= htmlspecialchars($category['name']) ?></label>
            </div>
        <?php endforeach; ?>
    </fieldset>
<br>
    <button>Zapisz</button>

</form>