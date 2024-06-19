<?php
session_start();
<<<<<<< HEAD
=======
<<<<<<< HEAD
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
include 'dbcon.php';

$user_id = 1; // Adjust this as needed

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
    header("Location: user_settings.php");
    exit();
} else {
    echo "Error updating record: " . mysqli_error($conn);
<<<<<<< HEAD
=======
=======
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
>>>>>>> adec6c4067db50e182594b88c33f3cc3db7b0e54
>>>>>>> 927693bf1b5d2809947b51c4257e8d2106397efe
}
?>
