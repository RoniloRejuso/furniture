<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Password</title>
    <!-- Include SweetAlert in the head section -->
    <script src='sweetalert.min.js'></script>
</head>
<body>

<?php
include('dbcon.php'); // Assuming this file correctly creates $conn

if ($conn->connect_error) {
    die('Could not connect to the database');
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];

    // Update the password for the user matching the username
    $changeQuery = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
    $changeQuery->bind_param('ss', $new_password, $username);
    $changeQuery->execute();

    if ($changeQuery->affected_rows > 0) {
        // Show JavaScript alert and redirect on successful password change
        echo "<script>
            alert('Password updated successfully!');
            window.location.href = 'login.php';
        </script>";
    } else {
        // Show JavaScript alert and redirect on failure
        echo "<script>
            alert('Failed to update password');
            window.location.href = 'change_password.php';
        </script>";
    }
} else {
    // Handle the case when the script is accessed directly without a proper request
    echo "<script>
        alert('Invalid request method');
        window.location.href = 'change_password.php';
    </script>";
}

$conn->close();

?>


<script src='sweetalert.min.js'></script>
</body>
</html>