<?php
function likesAlready(PDO $dbh, $post)
{
    $sth = $dbh->prepare("SELECT id
    FROM post_like
    WHERE post = :post
    AND auth_user = :auth_user");
    $sth->execute([":post" => $post, ":auth_user" => $_SESSION["user"]]);
    return ($sth->fetch());
}
