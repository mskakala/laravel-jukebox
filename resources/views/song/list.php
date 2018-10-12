<main>

    <h1>List of songs</h1>

    <div class="twocol">

        <div class="song-list list">

            <?php foreach ($songs as $song) : ?>

                <div class="song">
                    <h2><?= $song->name ?></h2>

                    <div class="author">
                        by <?= $song->author_name ?>
                    </div>

                    <div class="buttons">

                        <a href="/songs?id=<?= $song->id ?>" class="btn btn-success">play</a>

                        <a href="/songs/edit?id=<?= $song->id ?>" class="btn btn-primary">edit</a>

                        <form action="" method="post">
                            <?= csrf_field() ?>
                            <input type="hidden" name="id" value="<?= $song->id ?>">
                            <input type="submit" name="delete" value="delete" class="btn btn-danger" onclick="if (!confirm('Do you really want to delete this song?')) { return false; }">
                        </form>

                    </div>
                </div>

            <?php endforeach; ?>

        </div>

        <?php if (!empty($video)) : ?>

            <div class="player">

                <iframe width="560" height="315" src="https://www.youtube.com/embed/<?= $video['code'] ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>

            </div>

        <?php endif; ?>

    </div>

</main>