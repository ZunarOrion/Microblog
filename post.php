<?php
session_start();
include 'functions/db_connection.php';

//Finding post
$sth1 = $dbh->prepare("SELECT post.id, auth_user, content, email 
FROM post 
LEFT JOIN auth_user ON post.auth_user=auth_user.id 
WHERE post.id = :post_id");
$sth1->execute([":post_id" => $_GET['id']]);
$post = $sth1->fetch();
if (!$post) {
    die("No post exists");
};

//Check if user is already liking
$sth2 = $dbh->prepare("SELECT id 
FROM post_like 
WHERE post = :post 
AND auth_user = :auth_user");
$sth2->execute([":post" => $post->id, ":auth_user" => $_SESSION["user"]->id]);
$user_has_liked = $sth2->fetch();

//Likes counter
$sth3 = $dbh->prepare("SELECT COUNT(*) AS like_count 
FROM post_like 
WHERE post = :post");
$sth3->execute([":post" => $post->id]);
$likecount = $sth3->fetch()->like_count;

//Comments fetcher
require_once 'functions/comment_fetcher.php';
$comments = commentFetcher($dbh, (int)$_GET['id']);

include 'components/head.php';
?>

<div>
    <p hidden><?= $post->id ?></p>
    <p><?= $post->email ?></p>
    <p><?= $post->content ?></p>
    <!-- Like form -->
    <form action="functions/post_like.php" method="POST">
        <input type="text" name="post" value="<?= $post->id ?>" hidden>
        <input type="submit" value="<?= $user_has_liked ? 'Unlike' : 'Like' ?>">
    </form>
    <p><?= $likecount ?> likes</p>
    <!-- Comment form -->
    <form action="functions/comment_create.php" method="POST">
        <input type="text" name="post" value="<?= $post->id ?>" hidden>
        <h2 type="text" name="comment-header">Comment your thoughts about this post</h2>
        <textarea type="text" name="comment-input" placeholder="Write a comment..."></textarea>
        <button type="submit">Comment</button>
    </form>
    <!-- Comments on the post -->
    <div>
        <ul>
            <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                    <div>
                        <p hidden><?= $comment->id ?></p>
                        <p><?= $comment->auth_user ?></p>
                        <p><?= $comment->content ?></p>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>
        </ul>
    </div>
</div>

<?php
include 'components/footer.php';
?>