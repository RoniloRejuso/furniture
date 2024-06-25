<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Password</title>
    <script src='sweetalert.min.js'></script>
</head>
<body>

<?php
include('dbcon.php');

if ($conn->connect_error) {
    die('Could not connect to the database');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $new_password = $_POST['new_password'];

    $changeQuery = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
    $changeQuery->bind_param('ss', $new_password, $username);
    $changeQuery->execute();

    if ($changeQuery->affected_rows > 0) {
        echo "<script>
            alert('Password updated successfully!');
            window.location.href = 'login.php';
        </script>";
    } else {
        echo "<script>
            alert('Failed to update password');
            window.location.href = 'change_password.php';
        </script>";
    }
} else {
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
