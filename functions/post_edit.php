<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if ($_SESSION["user"]) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        include 'db_connection.php';
        $editI = $_POST['edit-input'];
        var_dump($_POST);
        if (empty($editI || !$_POST['post'])) {
            header("Location: ../profile.php?id=" . $_SESSION["user"]);
            exit;
        } else {
            $sth = $dbh->prepare("UPDATE post
            SET content = :edit_content
            WHERE id = :post_id 
            AND auth_user = :auth_user");
            $sth->execute([":edit_content" => $editI, ":post_id" => $_POST['post'], ":auth_user" => $_SESSION["user"]]);
            header("Location: ../profile.php?id=" . $_SESSION["user"]);
            exit;
        };
    };
} else {
    header("Location: ../login.php");
    exit;
}
