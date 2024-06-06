<?php
session_start();
include 'db_connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $barangay = $_POST['barangay'];
    $city = $_POST['city'];
    $postal_code = $_POST['postal_code'];
    $province = $_POST['province'];
    $contact = $_POST['contact'];

    // Concatenate address parts into one string
    $address = $barangay . ', ' . $city . ', ' . $postal_code . ', ' . $province;

    // Handle profile image upload
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
    } else {
        $image_path = ''; // Handle if no image uploaded
    }

    $user_id = $_SESSION['user_id'];

    $update_user_query = "UPDATE users SET firstname=?, lastname=?, address=?, phone_number=?, user_image=? WHERE user_id=?";
    $stmt = $conn->prepare($update_user_query);
    $stmt->bind_param("sssssi", $firstname, $lastname, $address, $contact, $image_path, $user_id);

    if ($stmt->execute()) {
        $_SESSION['message'] = "Profile updated successfully.";
    } else {
        $_SESSION['error'] = "Error updating profile: " . $conn->error;
    }

    $stmt->close();
    $conn->close();

    header("Location: user.php");
    exit();
} else {
    header("Location: user.php");
    exit();
}
?>
