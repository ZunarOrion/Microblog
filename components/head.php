<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microblog - <?= $title ?></title>
</head>

<body>
    <header>
        <h1>
            <a href="index.php">Logo</a>
        </h1>
        <nav>
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
                    <li>
                        <form action="functions/logout.php" method="POST">
                            <button type="submit">Logout</button>
                        </form>
                    </li>
                <?php else: ?> <!--utloggad -->
                    <li>
                        <!-- logga in knapp -->
                        <a href="login.php">Login</a>
                    </li>
                    <li>
                        <a href="signup.php">Signup</a>
                    </li>
                <?php endif ?>
            </ul>
        </nav>
    </header>