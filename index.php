    <!-- Showing posts -->
    <?php
    session_start();
    include 'functions/db_connection.php';

    $sth = $dbh->prepare("SELECT post.id, post_title, auth_user, email 
    FROM post 
    LEFT JOIN auth_user ON post.auth_user=auth_user.id");
    $sth->execute();
    $posts = $sth->fetchAll();



    // //Likes counter
    // require 'functions/likes_counter.php';
    // $likecount = likeCounter($dbh, (int)$_GET['id']);



    $title = "Home";
    include 'components/head.php';
    ?>

    <div>
        <ul>
            <?php if (count($posts) > 0): ?>
                <?php foreach ($posts as $post): ?>
                    <div>
                        <p hidden><?= $post->id ?></p>
                        <p id="email"><?= $post->email ?></p>
                        <p><?= $post->post_title ?></p>
                        <a href="post.php?id=<?= $post->id ?>">View post</a>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>
        </ul>
    </div>


    <?php include 'components/footer.php'; ?>