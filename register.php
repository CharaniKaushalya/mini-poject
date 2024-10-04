<?php
include 'config.php'; // Ensure this file sets up the $conn variable correctly

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data safely using null coalescing operator
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    // Debugging: Print the received POST data
    // Uncomment the line below for debugging
    // var_dump($_POST);

    // Check if all fields have been filled out
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // Bind parameters and execute
            $stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($stmt->execute()) {
                // Redirect to login page after successful registration
                header("Location: index.html");
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }

            $stmt->close();
        } else {
            echo "Error preparing statement: " . $conn->error;
        }
    } else {
        echo "Please fill in all fields.";
    }
}

// Close the connection
if (isset($conn)) {
    $conn->close();
}
?>
