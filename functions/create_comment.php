<?php
session_start();
if ($_SESSION["user"]) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connection.php';
        $commentI = $_POST['comment-input'];
        if (empty($commentI)) {
            echo "Text area is empty";
        } else {
            $sth = $dbh->prepare("INSERT INTO post_comment (content, post, auth_user) VALUES (:content, :post, :auth_user)");
            $sth->execute([":content" => $commentI, ":post" => $post->id, ":auth_user" => $_SESSION["user"]->id]);
            header("Location: ../post.php?id=" . $_POST["post"]);
            exit;
        };
    };
} else {
    header("Location: ../login.php");
    exit;
};
