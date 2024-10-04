<?php
// delete.php
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
    exit;
}

// Get POST data
$folderId = isset($_POST['id']) ? $_POST['id'] : null;
$folderName = isset($_POST['name']) ? $_POST['name'] : null;

// Validate inputs
if (!$folderId || !$folderName) {
    echo json_encode(['status' => 'error', 'message' => 'Missing folder ID or name.']);
    exit;
}

// Define the path to the folder (adjust as needed)
$folderPath = __DIR__ . '/uploads/' . basename($folderName);

// Check if the folder exists
if (!file_exists($folderPath)) {
    echo json_encode(['status' => 'error', 'message' => 'File does not exist.']);
    exit;
}

// Attempt to delete the folder/file
// If it's a file
if (is_file($folderPath)) {
    if (unlink($folderPath)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete the file.']);
    }
}
// If it's a directory
elseif (is_dir($folderPath)) {
    // Function to recursively delete a directory
    function deleteDir($dirPath) {
        if (!is_dir($dirPath)) {
            return false;
        }
        $items = scandir($dirPath);
        foreach ($items as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            $path = $dirPath . DIRECTORY_SEPARATOR . $item;
            if (is_dir($path)) {
                deleteDir($path);
            } else {
                unlink($path);
            }
        }
        return rmdir($dirPath);
    }

    if (deleteDir($folderPath)) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete the directory.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Unknown file type.']);
}
?>
