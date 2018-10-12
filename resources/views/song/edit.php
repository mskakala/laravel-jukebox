<main>

    <h1>Song edit</h1>


    <form action="" method="post">

        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name of the song" value="<?= htmlspecialchars($song['name']) ?>">
        </div>

        <div class="form-group">
            <label for="code">YouTube code</label>
            <input type="text" name="code" id="code" class="form-control" placeholder="Put the code here" value="<?= htmlspecialchars($song['code']) ?>">
        </div>

        <div class="form-group">
            <label for="author_id">Author</label>
            <select class="form-control" name="author_id" id="author_id">
                <?php foreach ($authors as $author_id => $author_name) : ?>
                    <option value="<?= $author_id ?>"<?= $author_id == $song['author_id'] ? ' selected' : '' ?>><?= htmlspecialchars($author_name) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
    
        <button type="submit" class="btn btn-primary">Submit</button>
    
    </form>

</main>