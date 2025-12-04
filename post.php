<?php
session_start();
include 'functions/db_connection.php';

$sth = $dbh->prepare("SELECT post.id, auth_user, content, email FROM post LEFT JOIN auth_user ON post.auth_user=auth_user.id WHERE post.id = :post_id");
$post_exist = $sth->execute([":post_id" => $_GET['id']]);
if (!$post_exist) {
    die("Post does not exit");
}
$post = $sth->fetch();

include 'components/head.php';

?>

<div>
    <p hidden><?= $post->id ?></p>
    <p><?= $post->email ?></p>
    <p><?= $post->content ?></p>
    <!-- Like function -->
    <form action="post_like.php" method="POST">
        <input type="text" name="post" value="<?= $post->id ?>" hidden>
        <input type="submit" value="Like">
    </form>
    <!-- Comment funktion -->
    <!-- Post comments -->
</div>

<?php
include 'components/footer.php';

?>