<?php
session_start();
if (!$_SESSION["user"]) {
    header("Location: login.php");
};
include 'functions/db_connection.php';

// Showing posts
$sth = $dbh->prepare("SELECT post.id, post_title, auth_user, email, created_at, updated_at
    FROM post 
    LEFT JOIN auth_user ON post.auth_user=auth_user.id");
$sth->execute();
$posts = $sth->fetchAll();

//Likes counter
require 'functions/likes_counter.php';


$title = "Home";
include 'components/head.php';
?>

<div class="content">
    <ul class="post-list">
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div class="post-card">
                    <p hidden><?= $post->id ?></p>
                    <div>
                        <div>
                            <a class="title" href="post.php?id=<?= $post->id ?>">
                                <?= $post->post_title ?></a>
                        </div>
                    </div>
                    <div>
                        <p>Likes: <?= $likecount = likeCounter($dbh, $post->id); ?></p>
                        <div>
                            <p>Made by: <?= $post->email ?></p>
                            <p class="posted-at">Posted at: <?= $post->created_at ?></p>
                            <p class="updated-at">Updated at: <?= $post->updated_at ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>
</div>


<?php include 'components/footer.php'; ?>