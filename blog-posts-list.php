<!DOCTYPE html>
<html lang="en">
<head>
    <?php include '../templates/shared_head.php';?>
    <link rel="stylesheet" href="blog.css">
    <title>Blog about analytics, open source and web development</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <?php include '../templates/header.php';?>

    <div class="fullwidth">
        <div class="content">
            <?php include 'postListRenderer.php'; ?>
        </div>
    </div>
    <?php include '../templates/footer.php';?>
</body>
</html>
