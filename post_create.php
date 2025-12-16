    <!-- Posting content -->
    <?php
    session_start();
    if ($_SESSION["user"]) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            include 'functions/db_connection.php';
            $titleI = $_POST['title-input'];
            $contentI = $_POST['content-input'];
            if (empty($contentI) || empty($titleI)) {
                $error = "Text area is empty";
            } else {
                $sth = $dbh->prepare("INSERT INTO post (content, auth_user, post_title) 
                VALUES (:content, :auth_user, :post_title)");
                $sth->bindParam(":post_title", $titleI);
                $sth->bindParam(":content", $contentI);
                $sth->bindValue(":auth_user", (int)$_SESSION["user"], PDO::PARAM_INT);
                if (!$sth->execute()) {
                    $post_creation_message = "Something went wrong with posting.";
                } else {
                    $post_creation_message = "Post has been created";
                };
            };
        };
    } else {
        header("Location: login.php");
        exit;
    };

    $title = "Create Post";
    include 'components/head.php';
    ?>

    <!-- Post form -->
    <form action="post_create.php" method="POST">
        <h2 type="text" name="content-header">Create a post</h2>
        <textarea type="text" name="title-input" placeholder="Put a title on your blog"></textarea>
        <textarea type="text" name="content-input" placeholder="Begin your blog"></textarea>
        <button type="submit">Create</button>
        <?php if (!empty($error)): ?>
            <p><?= htmlspecialchars($error); ?></p>
        <?php endif; ?>
        <?php if (!empty($post_creation_message)): ?>
            <p><?= htmlspecialchars($post_creation_message); ?></p>
        <?php endif; ?>
    </form>

    <?php include 'components/footer.php'; ?>