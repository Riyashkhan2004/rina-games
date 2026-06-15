<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection settings
$servername = "localhost";
$username = "root"; // Default username
$password = ""; // Default password (leave empty)
$dbname = "sign";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the email and password from the POST request
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT name, password FROM signup WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($name, $hashed_password);

    if ($stmt->fetch()) {
        // Debugging output
        // echo "Raw password: " . htmlspecialchars($password) . "<br>";
        // echo "Hashed password: " . htmlspecialchars($hashed_password) . "<br>";

        // Verify the password
        if (password_verify($password, $hashed_password)) {
            // Login successful
            echo '
            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Login Successful</title>
                <style>
                    body {
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100vh;
                        background-color: #f0f0f0;
                    }
                    .message-box {
                        text-align: center;
                        background-color: black;
                        color: white;
                        padding: 20px;
                        border-radius: 8px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
                    .btn {
                        margin-top: 20px;
                        padding: 10px 20px;
                        background-color: green;
                        color: white;
                        border: none;
                        border-radius: 5px;
                        cursor: pointer;
                        text-decoration: none; /* No underline for link */
                    }
                    .btn:hover {
                        background-color: #0056b3;
                    }
                </style>
            </head>
            <body>
                <div class="message-box">
                    <h2>Welcome ' . htmlspecialchars($name) . '!</h2>
                    <a href="main2.html" class="btn">Go to Home</a>
                </div>
            </body>
            </html>
            ';
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that email.";
    }

    $stmt->close();
}
$conn->close();
?>
