<?php
session_start(); // Start the session

$servername = "localhost"; // Replace with your database server name
$username = "root"; // Replace with your database username
$password = ""; // Replace with your database password
$dbname = "furniture"; // Replace with your database name

// Check if the user is already logged in
if (isset($_SESSION['user_id'])) {
    header("Location: user_index.php"); // Redirect to index page
    exit();
}

$error = ''; // Initialize error variable
// Create connection
$db = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($db->connect_error) {
    die("Connection failed: " . $db->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT user_id, firstname, lastname, email, password FROM users WHERE email = ?";
    $stmt = $db->prepare($sql);
    if ($stmt === false) {
        echo "Error preparing statement: " . $db->error;
        // Handle the error appropriately
    }
    $stmt->bind_param("s", $email);
    if ($stmt->execute() === false) {
        echo "Error executing statement: " . $stmt->error;
        // Handle the error appropriately
    }
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $stored_password = $row['password']; // Retrieve the password stored in the database

        // Compare the entered password with the stored password using password_verify()
        if (password_verify($password, $stored_password)) {
            $_SESSION['user_id'] = $row['user_id']; // Set the session variable upon successful login
            header("Location: user_index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "Invalid email or password.";
    }

    $stmt->close();
}

$db->close();
?>