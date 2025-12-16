<?php
session_start();
include 'functions/db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["signup-email"];
    $password_hash = password_hash($_POST["signup-password"], PASSWORD_DEFAULT);
    $sth1 = $dbh->prepare("SELECT * FROM auth_user 
    WHERE email = :email");
    $sth1->execute(["email" => $email]);
    $existing_user = $sth1->fetchAll();
    if ($existing_user) {
        $error = "Email is already taken";
    } else {
        $sth2 = $dbh->prepare("INSERT INTO auth_user (email, password_hash) 
        VALUES (:email, :password_hash)");
        $sth2->bindParam(":email", $email);
        $sth2->bindParam(":password_hash", $password_hash);
        $sth2->execute();
        header("Location: login.php");
        exit;
    };
};

$title = "Signup";
include 'components/head.php';
?>

<form action="signup.php" method="POST">
    <div>
        <label for="signup-email">Email:</label>
        <input type="email" name="signup-email" id="signup-email">
    </div>
    <div>
        <label for="signup-password">Password:</label>
        <input type="password" name="signup-password" id="signup-password">
    </div>
    <button type="submit">Signup</button>
    <?php if (!empty($error)): ?>
        <p><?= htmlspecialchars($error); ?></p>
    <?php endif; ?>
</form>

<?php include 'components/footer.php'; ?>