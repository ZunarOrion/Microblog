<?php
session_start();
include 'functions/db_connection.php';

// function data_validator($data)
// {
//     $data = trim($data);
//     $data = stripslashes($data);
//     $data = htmlspecialchars($data);
//     return $data;
// }

// $email = $password_hash = "";

// if ($_SERVER["REQUEST_METHOD"] == "POST") {
//     $email = data_validator($_POST["login-email"]);
//     $password_hash = data_validator($_POST["login-password"]);
// };

// Checking if email and password matches in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["login-email"];
    //!!!ADD PASSWORD HASHING!!!
    $password_hash = $_POST["login-password"];
    $sth = $dbh->prepare("SELECT * FROM auth_user WHERE email = :email AND password_hash = :password_hash");
    $sth->execute(["email" => $email, "password_hash" => $password_hash]);
    $existing_user = $sth->fetch();
    if ($existing_user) {
        echo "Welcome";
        $_SESSION["user"] = $existing_user;
        header("Location: index.php");
        exit;
    } else {
        echo "A user with that email not found";
    };

    var_dump($existing_user);
};



$title = "Login";
include 'components/head.php';
?>

<form action="login.php" method="POST">
    <div>
        <label for="login-email">Email:</label>
        <input type="email" name="login-email" id="login-email">
    </div>
    <div>
        <label for="login-password">Password:</label>
        <input type="password" name="login-password" id="login-password">
    </div>
    <button type="submit">Login</button>
</form>

<?php include 'components/footer.php'; ?>