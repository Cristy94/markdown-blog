# userTrack v3 released

Blog post coming soon...

# This is gpt-4.1-mini answer (20k in, 0k out)

The triple backtick conversion to HTML `<pre><code>` tags is handled in the `Parsedown.php` file, specifically in the methods related to fenced code blocks.

Look in `./markdown-blog/Parsedown.php` for these methods:

- `blockFencedCode($Line)` — detects the opening triple backticks (or tildes) and starts the fenced code block.
- `blockFencedCodeContinue($Line, $Block)` — continues the fenced code block until the closing triple backticks.
- `blockFencedCodeComplete($Block)` — completes the fenced code block.

These methods together parse the triple backtick fenced code blocks and generate the corresponding nested `<pre><code>` HTML elements with optional language classes for syntax highlighting.

So, the triple backtick to `<pre><code>` conversion is implemented in the `Parsedown` class inside `Parsedown.php` in the above methods.


