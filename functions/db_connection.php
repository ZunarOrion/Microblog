<!-- Database connection -->
<?php
$dsn = "mysql:host=127.0.0.1;dbname=microblog";
$username = "microblog";
$password = "password";

$dbh = new PDO($dsn, $username, $password);
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
