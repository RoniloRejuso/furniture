<?php
session_start(); // Start the session
include 'dbcon.php'; // Include your file where you establish the database connection

// Check if user is already logged in
if (isset($_SESSION['id'])) {
    header("Location: index.php"); // Redirect to index page
    exit();
}

$error = ''; // Initialize error variable

if (isset($_POST['submit1'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $query = "SELECT * FROM admin WHERE username=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $row = mysqli_fetch_assoc($result);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['id'] = $row['id']; // Assuming 'admin_id' is 'id' in your admin table
            if ($row['is_admin'] == 1) {
                header("Location: index.php");
                exit();
            } else {
                $error = "You are not an admin";
            }
        } else {
            $error = "Login Error: Please check your Username and Password";
        }
    } else {
        $error = "Database error: " . mysqli_error($conn);
    }
}
?>