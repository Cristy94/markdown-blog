<?php
    require_once 'postRenderer.php';

    $posts = getPostsList();
    foreach ($posts as $post) {
        $titleAndSummary = getFirstLines($post['markdown'], 3);
        $titleAndSummary = addTitleHref($titleAndSummary, $post['slug']);
?>
    <div class="blog-post">
        <?php echo renderMarkdown($titleAndSummary); ?>
        <span class="blog-post__date"><?php echo date( "d M Y", $post['create_date']); ?></span> - <a href="<?php echo $post['slug'] ?>">Read post</a>
    </div>
<?php }?>
