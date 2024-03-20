<?php
/**
 * Loads the markdown file given in the ?page query param into $markdown.
 */
require_once 'postRenderer.php';
$postSlug = $_GET['page'];
$page = __DIR__ . '/posts/' . $postSlug;

// Avoid path traversal, if /../ is passed
$realPath = realpath($page);
$containsPathTraversal = $realPath === false || strpos($realPath, __DIR__) !== 0;

if (!$containsPathTraversal && file_exists($page)) {
    $markdown = file_get_contents($page);
    $pageTitle = getPostTitle($markdown);
} else {
    header('HTTP/1.1 404 Not Found');
    $markdown = "# <center>404 😢<br/> Post not found<br/></center>";
    $markdown.= '<center><a href="./">Back to all posts</a></center>';
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
