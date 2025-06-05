<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog title</title>
    
    <!-- Bootstrap CSS from CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Ubuntu font from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@300;400;500;700&display=swap" rel="stylesheet">
    
    <!-- Highlight.js for code syntax highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/styles/atom-one-light.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="blog.css">
    
    <!-- RSS Feed -->
    <link rel="alternate" type="application/rss+xml" title="Blog RSS Feed" href="rss.php">
</head>
<body>
    <div class="container-fluid blog-container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="blog">
                    <header class="blog-header mb-5">
                        <h1 class="blog-title">Blog Title</h1>
                        <p class="blog-description text-muted">Your blog description goes here</p>
                        <div class="blog-meta">
                            <a href="rss.php" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-rss"></i> RSS Feed
                            </a>
                        </div>
                    </header>
                    <div class="blog-posts">
                        <?php include 'postListRenderer.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Highlight.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.11.1/highlight.min.js"></script>
    <script>hljs.highlightAll();</script>
</body>
</html>

