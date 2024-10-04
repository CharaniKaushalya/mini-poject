<?php
// rename.php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['old_name'], $_POST['new_name'])) {
    $uploadsDir = 'uploads/';
    $oldName = basename($_POST['old_name']);
    $newName = basename($_POST['new_name']);
    $oldFilePath = $uploadsDir . $oldName;
    $newFilePath = $uploadsDir . $newName;

    // Check if the old file exists
    if (file_exists($oldFilePath)) {
        // Rename the file
        if (rename($oldFilePath, $newFilePath)) {
            echo json_encode(['status' => 'success', 'message' => 'File renamed successfully.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'File renaming failed.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'File not found.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request.']);
}
?>
