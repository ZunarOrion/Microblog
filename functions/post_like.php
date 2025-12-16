<?php
session_start();
include 'db_connection.php';
$sth = $dbh->prepare("SELECT 1 FROM post_like 
WHERE post = :post 
AND auth_user = :auth_user
LIMIT 1");
$sth->execute([":post" => $_POST["post"], ":auth_user" => $_SESSION["user"]]);
$liked = $sth->fetch();
if ($liked) {
    $sth = $dbh->prepare("DELETE FROM post_like 
    WHERE post = :post 
    AND auth_user = :auth_user");
    $sth->execute([":post" => $_POST["post"], ":auth_user" => $_SESSION["user"]]);
    header("Location: ../post.php?id=" . $_POST["post"]);
    exit;
} else {
    $sth = $dbh->prepare("INSERT INTO post_like (post, auth_user) 
    VALUES (:post, :auth_user)");
    $sth->execute([":post" => $_POST["post"], ":auth_user" => $_SESSION["user"]]);
    header("Location: ../post.php?id=" . $_POST["post"]);
    exit;
};
