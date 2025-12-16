<?php
function commentFetcher(PDO $dbh, int $postId): array
{
    $sth = $dbh->prepare("SELECT post_comment.id, content, auth_user, auth_user.email, post
    FROM post_comment LEFT JOIN auth_user
    ON post_comment.auth_user=auth_user.id 
    WHERE post_comment.post = :post_id");
    $sth->execute([":post_id" => $postId]);
    return array_reverse($sth->fetchAll());
};
