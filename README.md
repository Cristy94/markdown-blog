# Markdown Blog
Extremly simple "static" PHP blog that renders markdown posts. **No installation or database needed**.

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
* Apache (or other .htaccess compatible web server)

## Installation
Copy the `markdown-blog` folder to a PHP server.  
You can also change the name of the folder, normally you would name it `blog` so you can access it like `yoursite.com/blog`.

## Usage
You can create new posts by adding new `post-url-slug.md` files in the `posts` folder.
The post must start with a `# Heading`, which will also be the title of the post and used in the `<title>` tag.

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

### 8 March 2021
- Added automatic generation of RSS feed. By default it can be accessed at /blog/rss.php
- Added settings.php file, holds basic configuration options and RSS channel details.
- Added some helper function to getPostsList (used in rendering posts and RSS feed).
- A few codebase improvements.

## License
MIT

## Check out my analytics script
This is the app for which I needed and created this blog project:  
[![Self-hosted analytics UXWizz](https://www.uxwizz.com/img/uxwizz_logo.png)](https://www.uxwizz.com/)  
Self-hosted analytics plaform with heatmaps and full session recordings.
