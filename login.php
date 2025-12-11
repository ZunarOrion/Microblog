<?php
session_start();
include 'functions/db_connection.php';

// Checking if email and password matches in the database
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["login-email"];
    $password = $_POST["login-password"];
    $sth = $dbh->prepare("SELECT * FROM auth_user WHERE email = :email");
    $sth->execute(["email" => $email]);
    $user = $sth->fetch();
    if (!$user) {
        $error = "Invalid email";
    } else if (!password_verify($password, $user->password_hash)) {
        $error = "Incorrect password";
    } else {
        $_SESSION["user"] = $user->id;
        header("Location: index.php");
        exit;
    };
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
    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>
</form>

<?php include 'components/footer.php'; ?>