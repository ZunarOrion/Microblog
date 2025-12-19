<?php
function followsAlready(PDO $dbh, $post)
{
    $sth = $dbh->prepare("SELECT id
    FROM follow
    WHERE followed = :followed
    AND follower = :follower");
    $sth->execute([":followed" => $post, ":follower" => $_SESSION["user"]]);
    return ($sth->fetch());
}
