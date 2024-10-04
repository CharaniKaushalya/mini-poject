<?php
header('Content-Type: application/json');

$uploadsDir = 'uploads/';
$files = array_diff(scandir($uploadsDir), array('.', '..'));

// Initialize an array to hold folder data
$folders = [];

foreach ($files as $file) {
    // Only list encrypted files
    if (strpos($file, 'encrypted_') === 0) {
        $fileId = md5($file); // Generate a unique ID based on the filename

        $folders[] = [
            'id' => $fileId,
            'folder_name' => $file,
            'download_link' => 'download.php?file=' . urlencode($file),
            'share_link' => 'share.php?file=' . urlencode($file),
            'rename_link' => 'rename.php'
        ];
    }
}

echo json_encode($folders);
?>
