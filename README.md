# Markdown Blog
Static PHP blog that renders markdown posts. No installation or database needed.

## Why?
You already have a site and want to integrate a blog within it.
I [asked others for recommendations](https://www.indiehackers.com/post/is-there-any-tool-to-create-static-blog-posts-0e88ebc949), but most suggestions involved some complex stand-alone blogging platform or service.  
I just wanted a simple way to create and display blog posts on my existing site.

## Solution
The solution came by combining several suggestions received in the post mentioned above with some of my own ideas:
 * Write blog posts in Markdown.
 * [Preview Markdown while typing directly in VSCode](https://code.visualstudio.com/docs/languages/markdown).
 * Use a PHP Markdown parsing library to load the `.md` files on the fly. I used [Parsedown](https://github.com/erusev/parsedown).
 * Use `.htaccess` rewrites for nice blog post URLs.

## Demo
You can see a [demo here](https://usertrack.net/blog).

## Usage
Copy the files to a PHP server and create new posts by adding new `post-url-slug.md` files in the `posts` folder.
The post must start with a `# Heading`, which will also be the title of the post and used in the `<title>` tag.

## Customization
The advantage of having something simple like this is that it's really easy to customize.
You can add your own `HTML` or `CSS` wherever you want. In the demo example I just added the `header.php` and `footer.php` that I use on the other pages of my static site.

The `md-styles.css` is just used to stylize the Markdown preview in Visual Studio Code. You can safely remove it, but having one means that you can preview your blog post in VSCode with the exact styles as on your site.


## License
MIT
