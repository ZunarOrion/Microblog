<?php
session_start();
if ($_SESSION["user"]) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connection.php';
        $commentI = $_POST['comment-input'];
        if (empty($commentI)) {
            header("Location: ../post.php?id=" . $_POST["post"]);
            exit;
        } else {
            $sth = $dbh->prepare("INSERT INTO post_comment (content, post, auth_user) 
            VALUES (:content, :post, :auth_user)");
            $sth->execute([":content" => $commentI, ":post" => $_POST["post"], ":auth_user" => $_SESSION["user"]]);
            header("Location: ../post.php?id=" . $_POST["post"]);
            exit;
        };
    };
} else {
    header("Location: ../login.php");
    exit;
};
