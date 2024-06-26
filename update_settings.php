<?php
session_start();
include 'dbcon.php';

$user_id = 1; // Adjust this as needed

// Fetch existing user data
$result = mysqli_query($conn, "SELECT * FROM users WHERE user_id = $user_id");
$user = mysqli_fetch_assoc($result);

if (!$user) {
    echo "User not found.";
    exit();
}

// Validate and sanitize input
$username = mysqli_real_escape_string($conn, $_POST['username']);
$email = mysqli_real_escape_string($conn, $_POST['email']);
$contact = mysqli_real_escape_string($conn, $_POST['contact']);
$address = mysqli_real_escape_string($conn, $_POST['address']);

// Split the username into firstname and lastname
$name_parts = explode(' ', $username);
$firstname = $name_parts[0];
$lastname = isset($name_parts[1]) ? $name_parts[1] : '';

// Handle profile picture upload
if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] == 0) {
    $file_name = $_FILES['profile_picture']['name'];
    $file_tmp = $_FILES['profile_picture']['tmp_name'];
    $file_type = $_FILES['profile_picture']['type'];
    $allowed_types = ['image/jpeg', 'image/png'];

    if (in_array($file_type, $allowed_types)) {
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $new_file_name = "profile_" . $user_id . "." . $file_ext;
        $upload_path = "uploads/" . $new_file_name;

        if (move_uploaded_file($file_tmp, $upload_path)) {
            $profile_picture = $upload_path;
        } else {
            echo "Failed to upload image.";
            exit();
        }
    } else {
        echo "Invalid file type. Only JPEG and PNG formats are allowed.";
        exit();
    }
} else {
    // If no new profile picture is uploaded, use the existing one
    $profile_picture = $user['profile_picture'];
}

// Update user data in the database
$query = "UPDATE users SET firstname = '$firstname', lastname = '$lastname', email = '$email', phone_number = '$contact', address = '$address', profile_picture = '$profile_picture' WHERE user_id = $user_id";

if (mysqli_query($conn, $query)) {
    header("Location: user.php");
    exit();
} else {
    echo "Error updating record: " . mysqli_error($conn);
}
?>
