     <!-- $sth4 = $dbh->prepare("SELECT post_comment.id, content, auth_user, post
    FROM post_comment LEFT JOIN auth_user
    ON post_comment.auth_user=auth_user.id WHERE post_comment.post = :post_id");
    $sth4->execute([":post_id" => $_GET['id']]);
    $comments = $sth4->fetchAll();
    $comments = array_reverse($comments); -->


     <?php
        function commentFetcher(PDO $dbh, int $postId): array
        {
            $sth4 = $dbh->prepare("SELECT post_comment.id, content, auth_user, post
        FROM post_comment LEFT JOIN auth_user
        ON post_comment.auth_user=auth_user.id WHERE post_comment.post = :post_id");
            $sth4->execute([":post_id" => $postId]);
            return array_reverse($sth4->fetchAll());
        };
        ?>
     <!-- require_once 'functions/comment_fetcher.php';
     $comments = commentFetcher($dbh, (int)$_GET['id']); -->