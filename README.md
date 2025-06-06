# Markdown Blog
Extremly simple "static" PHP blog that renders markdown posts. **No installation or database needed**.

Tired of complex blog setups, vendor lock-in or all the WordPress drama?

To create a post just write a new `.md` file. Everything else just works.

**Note**: It's not a full blogging platform, does not currently come with any premade themes, it's just a script and specific folder structure to load and display markdown files.

## Demo
You can see a usage [demo here](https://www.uxwizz.com/blog) (the blog is integrated into an existing site).

## Why?
You already have a site and want to integrate a blog within it.
I [asked others for recommendations](https://www.indiehackers.com/post/is-there-any-tool-to-create-static-blog-posts-0e88ebc949), but most suggestions involved some complex stand-alone blogging platform or service.  
I just wanted a simple way to create and display blog posts on my existing site.

## Solution
The solution came together by combining several suggestions received in the post mentioned above with some of my own ideas:
 * Write blog posts in Markdown.
 * [Preview Markdown while typing directly in VSCode](https://code.visualstudio.com/docs/languages/markdown).
 ![vscode-image-preview](https://code.visualstudio.com/assets/docs/languages/Markdown/preview-scroll-sync.gif)
 * Use a PHP Markdown parsing library to load the `.md` files on the fly. I used [Parsedown](https://github.com/erusev/parsedown). This means that no database is needed, there is no build step and you can easily version posts using git.
 * Use `.htaccess` rewrites for nice blog post URLs.

## Requirements

* PHP 5.4+
* Apache (or other .htaccess compatible web server that supports `SetEnv` for configuration).

## Installation
Copy the `markdown-blog` folder to a PHP server.  
You can also change the name of the folder, normally you would name it `blog` so you can access it like `yoursite.com/blog`.

### Configuration
Basic configuration is handled via environment variables set in the `.htaccess` file located in the `markdown-blog` directory. You should customize these values:

*   `AUTH_TOKEN`: A secret token for authorizing programmatic post uploads via `upload.php`. **Change `"A_STRONG_TOKEN"` to a secure, unique value.**
    ```apache
    SetEnv AUTH_TOKEN "YOUR_SECRET_STRONG_TOKEN"
    ```
*   `BLOG_TITLE`: The title of your blog, displayed on the posts list page.
    ```apache
    SetEnv BLOG_TITLE "My Awesome Blog"
    ```
*   `BLOG_DESCRIPTION`: A short description of your blog, also displayed on the posts list page.
    ```apache
    SetEnv BLOG_DESCRIPTION "A blog about awesome things"
    ```
The `settings.php` file contains configuration for the RSS feed details (`BLOG_RSS_TITLE`, `BLOG_RSS_DESCRIPTION`) and the path to blog posts (`BLOG_POSTS_PATH`).

## Usage
You can create new posts by adding new `post-url-slug.md` files in the `posts` folder.
The post must start with a `# Heading`, which will also be the title of the post and used in the `<title>` tag.

## Programmatic Post Upload (API)
You can programmatically upload new markdown posts using the `upload.php` script. This is useful for integrating with other tools or automating post creation.

*   **Endpoint:** `upload.php` (e.g., `http://yoursite.com/blog/upload.php`)
*   **Method:** `PUT`
*   **Authentication:**
    *   Requires an `X-MarkdownBlog-Token` header.
    *   The value of this header must match the `AUTH_TOKEN` environment variable set in your `.htaccess` file.
*   **Request Headers:**
    *   `Content-Type: text/markdown`
    *   `X-MarkdownBlog-Token: YOUR_SECRET_STRONG_TOKEN`
*   **Request Body:**
    *   Raw markdown content.
    *   The first line **must** be the post title, starting with `# ` (e.g., `# My Awesome Post`).
    *   The second line **must** be blank.
*   **Filename Generation:**
    *   The server automatically generates a filename for the post.
    *   The format is `YYYY-MM-DD-HHMMSS-sanitized-title.md`. The title is taken from the first line of your markdown content and sanitized (lowercase, spaces replaced with hyphens, special characters removed).
    *   If a file with the exact same generated name exists (highly unlikely due to the timestamp), a random 4-digit hexadecimal suffix is added before `.md`.
*   **Success Response (HTTP 201 Created):**
    *   `Content-Type: application/json`
    *   A JSON object containing details of the created post:
        ```json
        {
          "success": true,
          "filename": "2024-03-21-153000-my-awesome-post.md",
          "title": "My Awesome Post",
          "slug": "2024-03-21-153000-my-awesome-post",
          "url": "http://yoursite.com/blog/2024-03-21-153000-my-awesome-post"
        }
        ```
*   **Error Responses:**
    *   `400 Bad Request`: If `Content-Type` is not `text/markdown`, the request body is empty, or the markdown content does not follow the required format (e.g., first line not starting with `# `, second line not blank).
    *   `401 Unauthorized`: If the `X-MarkdownBlog-Token` header is missing or its value does not match the `AUTH_TOKEN` set in `.htaccess`.
    *   `405 Method Not Allowed`: If the request method is not `PUT`.
    *   `500 Internal Server Error`: If the server encounters an issue, such as being unable to create the `posts` directory or save the file.

### Example using `curl`:

To upload a local markdown file (`my-post.md`):
```bash
curl -X PUT \
  -H "Content-Type: text/markdown" \
  -H "X-MarkdownBlog-Token: YOUR_SECRET_STRONG_TOKEN" \
  --data-binary @my-post.md \
  http://yoursite.com/blog/upload.php
```

To upload markdown content directly:
```bash
curl -X PUT \
  -H "Content-Type: text/markdown" \
  -H "X-MarkdownBlog-Token: YOUR_SECRET_STRONG_TOKEN" \
  --data-raw "# My New Programmatic Post

This is the content of the post, uploaded via API.
The second line above this one was intentionally left blank." \
  http://yoursite.com/blog/upload.php
```

**Important:** Ensure your `my-post.md` file (or raw data) starts with a `# Title` on the first line and has a blank second line.

## Customization
The advantage of having something simple like this is that it's really easy to customize.

There are not really any default styles, as this is meant to be includded on your own site, which means it will inherit the CSS of your site. If you want better Markdown styling you can search for existing [Markdown themes](https://github.com/jasonm23/markdown-css-themes).

You can add your own `HTML` or `CSS` wherever you want. In the demo example I just added the `header.php` and `footer.php` that I use on the other pages of my static site.

The `md-styles.css` is just used to stylize the Markdown preview in Visual Studio Code. You can safely remove it, but having one means that you can preview your blog post in VSCode with the exact styles as on your site.

## Wait, but it uses PHP, why do you call it "static"?
You are right! It's not static as in just plain HTML served from a server.
But if you think about it, even a plain HTML site is hosted on a server which dynamically responds to HTTP requests.

I personally still consider it to be "static" because:

* I use **Cloudflare** on top of it with *cache everything* option, so requests do not reach my server, Cloudflare always responds with plain HTML/CSS, without executing the dynamic PHP code that processes the markdown.
* The servers that the client reaches are the Cloudflare servers, where the static assets are indeed served directly as-is.
* Content is written in a static file and doesn't change between requests.
* There is no database or content generated based on dynamic data (the only dynamic part is the URL, but it always points to the file name, the same as with static sites).
* There is no build step. If it's needed you can easily add a build step that simply saves the generated HTML output, thus making it truly satic. But now Cloudflare is already doing this.

*What exactly makes a website "static"?*

## Changelog

### 06 June 2025
- Add support for programmatic post upload via `upload.php` script.
- Updated Parsedown to the latest version.
- Improved style of the pages with [Bootstrap](https://getbootstrap.com/) and Ubuntu fonts.
- Added syntax highlighting for code blocks using [Highlight.js](https://highlightjs.org/).

### 20 March 2024
- ⚠️Security: Fix XSS issue with 404 posts. Thanks to [@Pinky](https://twitter.com/Pinkyakp/) for the report.
- ⚠️Security: Fix potential path traversal issue with 404 posts.
- Add 404 Not Found HTTP header to 404 posts (for better SEO and user experience).
  
### 20 Nov 2023
- Display post creation date in blog posts list
- Add ability to sort the blog posts list (default: newest first — sort descending by file creation date)

### 8 March 2021
- Added automatic generation of RSS feed. By default it can be accessed at /blog/rss.php
- Added settings.php file, holds basic configuration options and RSS channel details.
- Added some helper function to getPostsList (used in rendering posts and RSS feed).
- A few codebase improvements.

## License
MIT

## Keywords
Blog, PHP Blog, Markdown Blog, WordPress alternative, Ghost alternative, PHP Markdown

## Check out my analytics script
This is the app for which I needed and created this blog project:  
[![Self-hosted analytics UXWizz](https://www.uxwizz.com/img/uxwizz_logo.png)](https://www.uxwizz.com/)  
Self-hosted analytics plaform with heatmaps and full session recordings.

