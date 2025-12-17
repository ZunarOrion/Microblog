<?php
session_start();
include 'functions/db_connection.php';

//Finding post
$sth1 = $dbh->prepare("SELECT post.id, auth_user, post_title, content, email, created_at, updated_at 
FROM post 
LEFT JOIN auth_user ON post.auth_user=auth_user.id 
WHERE post.id = :post_id");
$sth1->execute([":post_id" => $_GET['id']]);
$post = $sth1->fetch();
if (!$post) {
    die("No post exists");
};

//Check if user is already liking and changes button accrodingly 
$sth2 = $dbh->prepare("SELECT id 
FROM post_like 
WHERE post = :post 
AND auth_user = :auth_user");
$sth2->execute([":post" => $post->id, ":auth_user" => $_SESSION["user"]]);
$user_has_liked = $sth2->fetch();

//Likes counter
require 'functions/likes_counter.php';
$likecount = likeCounter($dbh, (int)$_GET['id']);

//Check if user is already following and changes button accrodingly 
$sth3 = $dbh->prepare("SELECT id 
FROM follow 
WHERE followed = :followed 
AND follower = :follower");
$sth3->execute([":followed" => $post->id, ":follower" => $_SESSION["user"]]);
$user_has_followed = $sth3->fetch();

//Followers counter
require 'functions/follows_counter.php';
$followcount = followCounter($dbh, (int)$_GET['id']);

//Comments fetcher
require_once 'functions/comment_fetcher.php';
$comments = commentFetcher($dbh, (int)$_GET['id']);

include 'components/head.php';
?>

<div class="post-card">
    <p hidden><?= $post->id ?></p>
    <h1 class="title"><?= htmlspecialchars($post->post_title, ENT_QUOTES, 'UTF-8') ?></h1>
    <div>
        <div><?= htmlspecialchars($post->content, ENT_QUOTES, 'UTF-8') ?></div>
        <div>
            <p class="posted-at">Posted at: <?= $post->created_at ?></p>
            <p class="updated-at">Updated at: <?= $post->updated_at ?></p>
        </div>
        <div>
            <!-- Like form -->
            <p><?= $likecount ?> likes</p>
            <form action="functions/post_like.php" method="POST">
                <input type="text" name="post" value="<?= $post->id ?>" hidden>
                <input type="submit" value="<?= $user_has_liked ? 'Unlike' : 'Like' ?>">
            </form>
            <!-- Follow form -->
            <p><?= $followcount ?> followers</p>
            <form action="functions/follow.php" method="POST">
                <input type="text" name="post" value="<?= $post->id ?>" hidden>
                <input type="submit" value="<?= $user_has_followed ? 'Unfollow' : 'Follow' ?>">
            </form>
        </div>
        <div>
            <!-- Post creator -->
            <p id="email"><?= htmlspecialchars($post->email, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    </div>
    <!-- Comment form -->
    <form action="functions/comment_create.php" method="POST">
        <input type="text" name="post" value="<?= $post->id ?>" hidden>
        <h2 type="text" name="comment-header">Comment your thoughts about this post</h2>
        <textarea type="text" name="comment-input" placeholder="Write a comment..."></textarea>
        <button type="submit">Comment</button>
    </form>
    <!-- Comments on the post -->
    <div class="comments">
        <h3>Comments</h3>
        <ul>
            <?php if (count($comments) > 0): ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="comment">
                        <p hidden><?= $comment->id ?></p>
                        <p><?= htmlspecialchars($comment->content, ENT_QUOTES, 'UTF-8') ?></p>
                        <div>
                            <p id="email">Made by: <?= htmlspecialchars($comment->email, ENT_QUOTES, 'UTF-8') ?></p>
                            <p class="posted-at">Posted at: <?= $post->created_at ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif ?>
        </ul>
    </div>
</div>

<?php
include 'components/footer.php';
?>