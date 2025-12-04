<?php
session_start();
include 'db_connection.php';
$sth = $dbh->prepare("SELECT * FROM post_like WHERE post = :post AND auth_user = :auth_user");
$sth->execute([":post" => $_POST["post"], ":auth_user" => $_SESSION["user"]->id]);
$like = $sth->fetch();
// Knapp klickad -> prep plats i db -> fyll i placeholders med det som kommer från form
// hur får jag tag på datan från like form
if ($like) {
    $sth = $dbh->prepare("DELETE FROM post_like WHERE post = :post AND auth_user = :auth_user");
    $sth->execute([":post" => $_POST["post"], ":auth_user" => $_SESSION["user"]->id]);
    header("Location: /microblog/post.php?id=" . $_POST["post"]);
    exit;
} else {
    $sth = $dbh->prepare("INSERT INTO post_like (post, auth_user) VALUES (:post, :auth_user)");
    $sth->execute([":post" => $_POST["post"], ":auth_user" => $_SESSION["user"]->id]);
    header("Location: /microblog/post.php?id=" . $_POST["post"]);
    exit;
};
