<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>microblog</title>
</head>

<body>

    <!-- Users -->
    <form action="index.php" method="GET">
        <button type="submit" name="get-users">Get users</button>
    </form>

    <?php
    include 'functions/db_connection.php';

    if (isset($_GET['get-users'])) {
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $sth = $dbh->prepare("SELECT id, email, password_hash FROM auth_user");
        $sth->execute();
        $obj = $sth->fetchAll();


        if (count($obj) > 0) {
            foreach ($obj as $x) {
                echo nl2br("\n\n" . json_encode($x));
            };
            echo nl2br("\n\n");
        } else {
            echo "0 results";
        };
    };
    ?>

    <!-- Creating user -->
    <form action="index.php" method="POST">
        E-mail: <input type="text" name="email-input">
        password: <input type="password" name="password-input">
        <input type="submit">
    </form>

    <?php
    include 'functions/db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $emailI = $_POST['email-input'];
        $passwordI = $_POST['password-input'];

        if (empty($emailI) || empty($passwordI)) {
            echo "E-mail or Password is empty";
        } else {
            // $passwordHash = password_hash($passwordI, PASSWORD_DEFAULT);

            $sth = $dbh->prepare("INSERT INTO auth_user (email, password_hash) VALUES (:email, :password)");
            $sth->bindParam(":email", $emailI);
            $sth->bindParam(":password", $passwordI);

            if ($sth->execute()) {
                echo "$emailI has been registered";
            } else {
                echo "Something went wrong";
            }
        };
    };
    ?>

    <!-- Show followers -->
    <form action="index.php" method="GET">
        <button type="submit" name="get-followers">Show followers</button>
    </form>

    <?php
    if (isset($_GET['get-followers'])) {
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $sth = $dbh->prepare("SELECT id,follower, followed FROM follow");
        $sth->execute();
        $obj = $sth->fetchAll();

        if (count($obj) > 0) {
            foreach ($obj as $x) {
                echo nl2br("\n\n" . json_encode($x));
            };
            echo nl2br("\n\n");
        } else {
            echo "0 followers found";
        };
    };
    ?>

    <!-- Showing posts -->
    <form action="index.php" method="GET">
        <button type="submit" name="get-posts">Get posts</button>
    </form>

    <?php
    include 'functions/db_connection.php';

    if (isset($_GET['get-posts'])) {
        $dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $sth = $dbh->prepare("SELECT id, content, auth_user FROM post");
        $sth->execute();
        $obj = $sth->fetchAll();


        if (count($obj) > 0) {
            foreach ($obj as $x) {
                echo nl2br("\n\n" . json_encode($x));
            };
            echo nl2br("\n\n");
        } else {
            echo "0 posts found";
        };
    };
    ?>

    <!-- Posting content -->
    <form action="index.php" method="POST">
        <h2 type="text" name="content-header">Write a post</h2>
        <textarea type="text" name="content-input" placeholder="Begin your blog"></textarea>
        <button type="submit">Post</button>
    </form>

    <?php
    include 'functions/db_connection.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $contentI = $_POST['content-input'];

        if (empty($contentI)) {
            echo "Text area is empty";
        } else {
            $sth = $dbh->prepare("INSERT INTO post (content) VALUES (:content)");
            $sth->bindParam(":content", $contentI);

            if ($sth->execute()) {
                echo "Post has been created";
            } else {
                echo "Something went wrong with posting";
            };
        };
    };
    ?>

</html>