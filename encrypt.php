<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file']['tmp_name'];
    $originalFilename = basename($_FILES['file']['name']);
    $encryptedFilename = 'encrypted_' . uniqid() . '_' . $originalFilename;
    $encryptedFilepath = 'uploads/' . $encryptedFilename;

    // Create uploads directory if it doesn't exist
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Encryption key (should be stored securely)
    $key = 'mysecretkey'; // Replace with your encryption key

    // Read file contents
    $data = file_get_contents($file);

    // Encrypt data using AES-128-ECB
    $encryptedData = openssl_encrypt($data, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

    // Optionally, encode the encrypted data to base64 for storage
    $encryptedData = base64_encode($encryptedData);

    // Save encrypted file
    if (file_put_contents($encryptedFilepath, $encryptedData) !== false) {
        echo json_encode([
            'success' => true,
            'filename' => $encryptedFilename,
            'filepath' => $encryptedFilepath
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to save the encrypted file.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or no file uploaded.']);
}
?>
