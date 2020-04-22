<?php
    /**
     * Loads the markdown file given in the ?page query param into $markdown.
     */
    require_once 'postRenderer.php';
    $postSlug = $_GET['page'];
    $page = 'posts/' . $postSlug;
    if (file_exists($page)) {
        $markdown = file_get_contents($page);
        $pageTitle = getPostTitle($markdown);
    } else {
        $markdown = "# 404 <br/> Post '$postSlug' not found 😢 ";
        $pageTitle = 'Blog post not found!';
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../templates/shared_head.php';?>
    <link rel="stylesheet" href="blog.css">
    <title><?php echo $pageTitle ?> | userTrack</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php include '../templates/header.php';?>
    <?php

    ?>
        <div class="fullwidth">
            <div class='content markdown'>
                <?php echo renderMarkdown($markdown); ?>
            </div>
        </div>
    <?php include '../templates/footer.php';?>
    </body>
</html>