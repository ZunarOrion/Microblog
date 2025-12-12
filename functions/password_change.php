<?php
include 'db_connection.php';

$auth_user_id = "1";
$password_hash = "1234567890";
$sth = $dbh->prepare("UPDATE auth_user 
SET password_hash = :password_hash 
WHERE id = :auth_user_id");
$updated = $sth->execute(["password_hash" => $password_hash, "auth_user_id" => $auth_user_id]);

if ($updated) {
    header("Location: ../profile.php?password_changed=1");
    exit;
} else {
    header("Location: ../profile.php?password_changed=0");
    exit;
};
