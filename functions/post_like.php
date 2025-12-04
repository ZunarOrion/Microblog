<?php
include 'db_connection.php';
$sth = $dbh->prepare("INSERT INTO post_like (post, auth_user) VALUES (:post, :auth_user)");
$sth->execute([":post" => $_POST["post"], ":auth_user" => $_SESSION["user_id"]]);
$like = $sth->fetch();
// Knapp klickad -> prep plats i db -> fyll i placeholders med det som kommer från form
// hur får jag tag på datan från like form
