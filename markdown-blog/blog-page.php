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
    <link rel="stylesheet" href="blog.css">
    <title><?php echo $pageTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="blog">
        <div class='markdown'>
                <?php echo renderMarkdown($markdown); ?>
        </div>
    </div>
</body>
</html>
