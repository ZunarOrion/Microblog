<?php
function likeCounter(PDO $dbh,  $post)
{
    $sth = $dbh->prepare("SELECT COUNT(*) AS like_count 
    FROM post_like 
    WHERE post = :post");
    $sth->execute([":post" => $post]);
    return ($sth->fetch()->like_count);
}
