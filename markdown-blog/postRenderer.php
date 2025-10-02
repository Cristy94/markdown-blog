<?php
    require_once __DIR__ .'/Parsedown.php';
    require_once __DIR__ .'/ParsedownExtra.php';
    require_once __DIR__ .'/settings.php';

    $Parsedown = new ParsedownExtra();

    function renderMarkdown($markdown) {
        global $Parsedown;
        return $Parsedown->text($markdown);
    }

    function getPostSlug($fileName) {
        // Post slug is filename, without .md extension
        return substr($fileName, 0, -3);
    }

    function getPostTitle($postContent) {
        // Gets first # TITLE markdown and returns only text
        $titlePattern = '/^# (.*)/';
        preg_match($titlePattern, $postContent, $matches);
        return $matches[1];
    }

    function addTitleHref($postContent, $slug) {
        // Make post title clickable (links to post slug)
        $firstLinePattern = '/^# (.*)(\r\n|\r|\n)$/m';
        $replacement  = '# [${1}]('. $slug . ')${2}'; // # [title](slug)NEW_LINE
        return preg_replace($firstLinePattern, $replacement, $postContent);
    }

    function getFirstLines($string, $count, $skip = 0) {
        $lines = preg_split('/\r\n|\r|\n/', $string);
        $sliced = array_slice($lines, $skip, $count);
        return implode(PHP_EOL, $sliced);
    }

    function getExternalURL($slug) {
        return  'https://' . $_SERVER['HTTP_HOST'] . substr($_SERVER['REQUEST_URI'], 0, strrpos($_SERVER['REQUEST_URI'], '/') + 1) . $slug;
    }

    function getSortedFiles($files, $sort) {
        // Sort files descending by CREATED or MODIFIED time
        if (!$sort) return $files;
        
        $sortedFiles = array();
        foreach ($files as $file) {
            if ($sort === 'CREATED') {
                $sortedFiles[$file] = filectime(BLOG_POSTS_PATH . '/' . $file);
            } else if($sort === 'MODIFIED'){
                $sortedFiles[$file] = filemtime(BLOG_POSTS_PATH . '/' . $file);
            }
        }
    
        arsort($sortedFiles);
        return array_keys($sortedFiles);
    }

    function getPostsList($sort = 'CREATED') {
        $files = array_slice(scandir(BLOG_POSTS_PATH), 2);

        $sortedFiles = getSortedFiles($files, $sort);
        
        $posts_list = array();

        // Get only summary (first lines of post)
        foreach ($sortedFiles as $file) {
            $filePath = BLOG_POSTS_PATH . '/' . $file;
            $md = file_get_contents($filePath);
            $slug = getPostSlug($file);
    
            $posts_list[] = array(
                'title' => getPostTitle($md),
                'slug' => $slug,
                'markdown' => $md,
                'file' => $file,
                'create_date' => filectime($filePath)
            );
        }

        return $posts_list;
    }
?>
