<?php
if (isset($_GET['file'])) {
    $filename = basename($_GET['file']);
    $filepath = 'uploads/' . $filename;

    if (file_exists($filepath)) {
        // In a real-world scenario, implement token-based or time-limited links
        // For simplicity, we'll provide the direct download link
        $shareLink = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/download.php?file=' . urlencode($filename);
        echo $shareLink;
    } else {
        http_response_code(404);
        echo "File not found.";
    }
} else {
    http_response_code(400);
    echo "No file specified.";
}
?>
