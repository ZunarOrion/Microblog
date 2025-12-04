    <!-- Posting content -->
    <?php
    session_start();
    if ($_SESSION["user"]) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'functions/db_connection.php';
            $contentI = $_POST['content-input'];
            if (empty($contentI)) {
                echo "Text area is empty";
            } else {
                $sth = $dbh->prepare("INSERT INTO post (content, auth_user) VALUES (:content, :auth_user)");
                $sth->bindParam(":content", $contentI);
                $sth->bindParam(":auth_user", $_SESSION["user"]->id);
                if ($sth->execute()) {
                    echo "Post has been created";
                } else {
                    echo "Something went wrong with posting";
                };
            };
        };
    } else {
        header("Location: login.php");
        exit;
    };
    var_dump($_SESSION["user"]);

    $title = "Create Post";
    include 'components/head.php';
    ?>

    <form action="create_post.php" method="POST">
        <h2 type="text" name="content-header">Create a post</h2>
        <textarea type="text" name="content-input" placeholder="Begin your blog"></textarea>
        <button type="submit">Create</button>
    </form>

    <?php include 'components/footer.php'; ?>