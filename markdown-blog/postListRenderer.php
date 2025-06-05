<?php
    require_once 'postRenderer.php';

    $posts = getPostsList();
    foreach ($posts as $post) {
        $titleAndSummary = getFirstLines($post['markdown'], 3);
        $titleAndSummary = addTitleHref($titleAndSummary, $post['slug']);
?>
    <div class="blog-post">
        <article>
            <?php echo renderMarkdown($titleAndSummary); ?>
            <div class="blog-post-meta">
                <span class="blog-post__date">
                    <i class="bi bi-calendar3"></i> <?php echo date( "d M Y", $post['create_date']); ?>
                </span> 
                <span class="mx-2">•</span>
                <a href="<?php echo $post['slug'] ?>" class="btn btn-sm btn-primary">Read post →</a>
            </div>
        </article>
    </div>
<?php }?>

