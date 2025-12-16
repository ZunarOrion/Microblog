<?php
session_start();
include 'functions/db_connection.php';

//Finding users posts
$sth = $dbh->prepare("SELECT post.id, content, auth_user, auth_user.email, created_at, updated_at 
FROM post
LEFT JOIN auth_user
ON post.auth_user=auth_user.id
WHERE auth_user = :user_id");
$sth->execute(["user_id" => $_SESSION["user"]]);
$posts = $sth->fetchAll();

//Followers counter
require 'functions/follows_counter.php';
$followcount = followCounter($dbh, (int)$_SESSION['user']);

$title = "Profile";
include 'components/head.php';
?>

<h1>Your Profile</h1>
<p>You have <?= $followcount ?> followers</p>
<!-- users profile settings -->
<div>
    <h2>Change your password</h2>
    <form action="functions/password_change.php" method="POST">
        <label for="change-password">Password</label>
        <input type="password" name="change-password" id="change-password">
        <input type="submit" value="Change password">
    </form>

    <?php if (isset($_GET['password_changed'])): ?>
        <?php if ($_GET['password_changed'] == true): ?>
            <p>Password changed!</p>
        <?php else: ?>
            <p>An error occurred</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Password input is empty!</p>
    <?php endif; ?>
</div>

<!-- users posts -->
<h2>Your posts</h2>
<div>
    <ul>
        <?php if (count($posts) > 0): ?>
            <?php foreach ($posts as $post): ?>
                <div>
                    <p>Posted at: <?= $post->created_at ?></p>
                    <p><?= $post->content ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif ?>
    </ul>
</div>

<?php include 'components/footer.php'; ?>