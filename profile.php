<?php
session_start();
include 'functions/db_connection.php';
$user_id = 1;
$sth = $dbh->prepare("SELECT id, content, auth_user FROM post WHERE auth_user = :user_id");
$sth->execute(["user_id" => $user_id]);
$posts = $sth->fetchAll();

$title = "Profile";
include 'components/head.php';
?>

<!-- users profile settings -->
<div>
    <h2>Change your password</h2>
    <form action="functions/change_password.php" method="POST">
        <label for="change-password">Password</label>
        <input type="password" name="change-password" id="change-password">
        <input type="submit" value="Change password">
    </form>

</div>

<!-- users posts -->
<h2>Your posts</h2>
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