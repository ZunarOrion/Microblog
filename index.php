    <!-- Showing posts -->
    <?php
    session_start();
    include 'functions/db_connection.php';

    $sth = $dbh->prepare("SELECT id, content, auth_user FROM post");
    $sth->execute();
    $posts = $sth->fetchAll();

    var_dump($_SESSION);

    $title = "Home";
    include 'components/head.php';
    ?>

    <div>
        <ul>
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div>
                        <p><?= $post->auth_user ?></p>
                        <p><?= $post->content ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>
        </ul>
    </div>


    <?php include 'components/footer.php'; ?>