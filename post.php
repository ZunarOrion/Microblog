<?php
session_start();
include 'functions/db_connection.php';

//Like post
$sth1 = $dbh->prepare("SELECT post.id, auth_user, content, email 
FROM post LEFT JOIN auth_user 
ON post.auth_user=auth_user.id WHERE post.id = :post_id");
$post_exist = $sth1->execute([":post_id" => $_GET['id']]);
if (!$post_exist) {
    die("No Post exists");
}
$post = $sth1->fetch();

//Check if user is already liking
$sth2 = $dbh->prepare("SELECT id FROM post_like 
WHERE post = :post AND auth_user = :auth_user");
$sth2->execute([":post" => $post->id, ":auth_user" => $_SESSION["user"]->id]);
$user_has_liked = $sth2->fetch();

//Likes counter
$sth3 = $dbh->prepare("SELECT COUNT(*) AS like_count FROM post_like 
WHERE post = :post");
$sth3->execute([":post" => $post->id]);
$likecount = $sth3->fetch()->like_count;

include 'components/head.php';
var_dump($_SESSION["user"]->id);
?>

<div>
    <p hidden><?= $post->id ?></p>
    <p><?= $post->email ?></p>
    <p><?= $post->content ?></p>
    <!-- Like function -->
    <form action="functions/post_like.php" method="POST">
        <input type="text" name="post" value="<?= $post->id ?>" hidden>
        <input type="submit" value="<?= $user_has_liked ? 'Unlike' : 'Like' ?>">
    </form>
    <p><?= $likecount ?> likes</p>
    <!-- Comment funktion -->
    <!-- Post comments -->
</div>

<?php
include 'components/footer.php';
?>