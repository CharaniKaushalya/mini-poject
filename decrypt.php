<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['encryptedFile'])) {
    $file = $_FILES['encryptedFile']['tmp_name'];
    $filename = basename($_FILES['encryptedFile']['name']);
    $decryptedFilename = 'decrypted_' . preg_replace('/^encrypted_/', '', $filename);
    $decryptedFilepath = 'uploads/' . $decryptedFilename;

    // Create uploads directory if it doesn't exist
    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Encryption key (must match the key used in encryption)
    $key = 'mysecretkey'; // Replace with your encryption key

    // Read encrypted file contents
    $encryptedData = file_get_contents($file);

    // Base64 decode the encrypted data
    $encryptedData = base64_decode($encryptedData);

    // Decrypt data using AES-128-ECB
    $decryptedData = openssl_decrypt($encryptedData, 'AES-128-ECB', $key, OPENSSL_RAW_DATA);

    // Check if decryption was successful
    if ($decryptedData !== false) {
        // Save decrypted file
        if (file_put_contents($decryptedFilepath, $decryptedData) !== false) {
            echo json_encode([
                'success' => true,
                'filename' => $decryptedFilename,
                'filepath' => $decryptedFilepath
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to save the decrypted file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Decryption failed. Please check your encryption key and data.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request or no file uploaded.']);
}
?>
