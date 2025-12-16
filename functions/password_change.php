<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../login.php");
    exit;
};
$auth_user_id = $_SESSION['user'];
$password_hash = password_hash($_POST["change-password"], PASSWORD_DEFAULT);
if (empty($_POST['change-password'])) {
    header("Location: ../page.php?password_changed=empty");
    exit;
};
$sth = $dbh->prepare("UPDATE auth_user 
SET password_hash = :password_hash 
WHERE id = :auth_user_id");
$updated = $sth->execute(["password_hash" => $password_hash, "auth_user_id" => $auth_user_id]);

if ($updated && $sth->rowCount() > 0) {
    header("Location: ../profile.php?password_changed=1");
    exit;
} else {
    header("Location: ../profile.php?password_changed=0");
    exit;
};
