<?php
// Database configuration
$servername = "localhost"; // Default server name for WAMP
$username = "root";         // Default username for WAMP
$password = "";             // Default password (usually empty for WAMP)
$dbname = "reg";  // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = password_hash(trim($_POST['password']), PASSWORD_BCRYPT); // Hash the password

    // Prepare SQL query
    $sql = "INSERT INTO register (username, email, password) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $username, $email, $password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "User registered successfully!";
        // Optionally redirect to login page or another page
        // header("Location: login.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
