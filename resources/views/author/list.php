<main>

    <h1>List of authors</h1>

    <div class="author-list list">

        <?php foreach ($authors as $author) : ?>

            <div class="author">
                <h2><?= $author->name ?></h2>

                <div class="buttons">

                    <a href="/authors/edit?id=<?= $author->id ?>" class="btn btn-primary">edit</a>

                    <form action="" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="id" value="<?= $author->id ?>">
                        <input type="submit" name="delete" value="delete" class="btn btn-danger" onclick="if (!confirm('Do you really want to delete this author?')) { return false; }">
                    </form>

                </div>
            </div>

        <?php endforeach; ?>

    </div>

</main>