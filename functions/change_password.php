<?php
include 'db_connection.php';

$auth_user_id = "1";
$password_hash = "1234567890";
$sth = $dbh->prepare("UPDATE auth_user SET password_hash = :password_hash WHERE id = :auth_user_id");
$updated = $sth->execute(["password_hash" => $password_hash, "auth_user_id" => $auth_user_id]);

if ($updated) {
    echo "Password changed";
} else {
    echo "Password was not changed";
};
