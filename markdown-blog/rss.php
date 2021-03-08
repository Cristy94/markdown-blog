<?php

require_once 'postRenderer.php';

header("Content-type: text/xml");

echo "<?xml version='1.0' encoding='UTF-8'?>
 <rss version='2.0'>
 <channel>
 <title>" . BLOG_RSS_TITLE . "</title>
 <link>" . getExternalURL('') . "</link>
 <description>" . BLOG_RSS_DESCRIPTION . "</description>
 <language>en-us</language>";

$posts = getPostsList();
foreach ($posts as $post) {
    $title = $post["title"];
    $link = getExternalURL($post['slug']);
    $description = strip_tags(renderMarkdown(getFirstLines($post['markdown'], 4, 1)));

    echo "<item>
   <title>$title</title>
   <link>$link</link>
   <description>$description</description>
   <pubDate>" . date(DATE_RSS, $post["create_date"]) . "</pubDate>
   </item>";
}
echo "</channel></rss>";

?>