<?php
session_start();
include 'db_connection.php';
$sth = $dbh->prepare("SELECT 1 FROM follow
WHERE follower = :follower
AND followed = :followed
LIMIT 1");
if ((int)$_SESSION["user"] === (int)$_POST["post"]) {
    header("Location: ../post.php?id=" . $_POST["post"]);
};
$sth->execute([":followed" => $_POST["post"], ":follower" => $_SESSION["user"]]);
$following = $sth->fetch();
if ($following) {
    $sth = $dbh->prepare("DELETE FROM follow
    WHERE follower = :follower
    AND followed = :followed");
    $sth->execute([":followed" => $_POST["post"], ":follower" => $_SESSION["user"]]);
    header("Location: ../post.php?id=" . $_POST["post"]);
    exit;
} else {
    $sth = $dbh->prepare("INSERT INTO follow (follower, followed)
    VALUES (:follower, :followed)");
    $sth->execute([":followed" => $_POST["post"], ":follower" => $_SESSION["user"]]);
    header("Location: ../post.php?id=" . $_POST["post"]);
    exit;
};
