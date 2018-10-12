<main>

    <h1>Author edit</h1>


    <form action="" method="post">

        <?= csrf_field() ?>

        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" placeholder="Name of the author" value="<?= htmlspecialchars($author['name']) ?>">
        </div>

        <div class="form-group">
            <label for="img_url">Image URL</label>
            <input type="text" name="img_url" id="img_url" class="form-control" placeholder="URL to image somewher on the Interneg" value="<?= htmlspecialchars($author['img_url']) ?>">
        </div>
            
        <button type="submit" class="btn btn-primary">Submit</button>
    
    </form>

</main>