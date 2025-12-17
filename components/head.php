<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microblog - <?= $title ?></title>
    <style>
        <?php include 'style.css' ?>
    </style>
</head>

<body>
    <header class="navbar">
        <div class="nav-left">
            <a href="index.php" class="logo">Logo</a>
        </div>
        <nav class="nav-center">
            <ul>
                <li>
                    <a href="index.php">Home</a>
                </li>
                <?php if (!empty($_SESSION["user"])): ?> <!--Inloggad-->
                    <li>
                        <a href="profile.php">Profile</a>
                    </li>
                    <li>
                        <a href="post_create.php">Create Post</a>
                    </li>
                <?php else: ?> <!--utloggad -->
                    <li>
                        <a href="login.php">Login</a>
                    </li>
                    <li>
                        <a href="signup.php">Signup</a>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
        <div class="nav-right">
            <?php if (!empty($_SESSION["user"])): ?>
                <form action="functions/logout.php" method="POST">
                    <button type="submit">Logout</button>
                </form>
            <?php endif; ?>
        </div>
    </header>
    <main>