<?php
/**
 * Upload handler for markdown blog posts
 * Accepts PUT requests with markdown content
 * Requires authentication via X-MardkdownBlog-Token header
 */

// Configuration
define('UPLOAD_TOKEN', 'MihaminaRKTMB'); // Change this to a secure token
define('POSTS_DIR', __DIR__ . '/posts');

// Only accept PUT requests
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    header('Allow: PUT');
    die('Method Not Allowed. Only PUT requests are accepted.');
}

// Check Content-Type header
$contentType = $_SERVER['CONTENT_TYPE'] ?? '';
if ($contentType !== 'text/markdown') {
    http_response_code(400);
    die('Bad Request. Content-Type must be text/markdown.');
}

// Check authentication token
$providedToken = $_SERVER['HTTP_X_MARDKDOWNBLOG_TOKEN'] ?? '';
if ($providedToken !== UPLOAD_TOKEN) {
    http_response_code(401);
    die('Unauthorized. Invalid or missing X-MardkdownBlog-Token header.');
}

// Read the request body
$content = file_get_contents('php://input');
if (empty($content)) {
    http_response_code(400);
    die('Bad Request. Request body is empty.');
}

// Split content into lines
$lines = explode("\n", $content);
if (count($lines) < 2) {
    http_response_code(400);
    die('Bad Request. File must have at least 2 lines.');
}

// Check first line starts with "# "
if (!preg_match('/^# (.+)/', $lines[0], $matches)) {
    http_response_code(400);
    die('Bad Request. First line must start with "# " followed by the title.');
}

// Extract title from first line
$title = trim($matches[1]);

// Check second line is blank
if (trim($lines[1]) !== '') {
    http_response_code(400);
    die('Bad Request. Second line must be blank.');
}

// Sanitize title for filename
// Remove any characters that are not alphanumeric, spaces, hyphens, or underscores
$sanitizedTitle = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $title);
// Replace multiple spaces with single space
$sanitizedTitle = preg_replace('/\s+/', ' ', $sanitizedTitle);
// Trim and replace spaces with hyphens
$sanitizedTitle = str_replace(' ', '-', trim($sanitizedTitle));
// Convert to lowercase
$sanitizedTitle = strtolower($sanitizedTitle);
// Remove multiple consecutive hyphens
$sanitizedTitle = preg_replace('/-+/', '-', $sanitizedTitle);
// Trim hyphens from start and end
$sanitizedTitle = trim($sanitizedTitle, '-');

// Generate filename with timestamp
$timestamp = date('Y-m-d-His');
$filename = $timestamp . '-' . $sanitizedTitle . '.md';
$filepath = POSTS_DIR . '/' . $filename;

// Ensure posts directory exists
if (!is_dir(POSTS_DIR)) {
    if (!mkdir(POSTS_DIR, 0755, true)) {
        http_response_code(500);
        die('Internal Server Error. Could not create posts directory.');
    }
}

// Check if file already exists (unlikely due to timestamp, but good practice)
if (file_exists($filepath)) {
    http_response_code(409);
    die('Conflict. A file with this name already exists.');
}

// Save the file
if (file_put_contents($filepath, $content) === false) {
    http_response_code(500);
    die('Internal Server Error. Could not save file.');
}

// Return success response
http_response_code(201);
header('Content-Type: application/json');
echo json_encode([
    'success' => true,
    'filename' => $filename,
    'title' => $title,
    'slug' => substr($filename, 0, -3), // Remove .md extension
    'url' => getPostUrl(substr($filename, 0, -3))
]);

/**
 * Get the full URL for a post
 * @param string $slug The post slug (filename without .md)
 * @return string The full URL to the post
 */
function getPostUrl($slug) {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'];
    $path = dirname($_SERVER['REQUEST_URI']);
    // Remove trailing slash from path if it exists
    $path = rtrim($path, '/');
    return $protocol . '://' . $host . $path . '/' . $slug;
}
?>

