<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Our Home</title>
    <script src='sweetalert.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>

<?php

include('dbcon.php');

if ($conn->connect_error) {
    die('Could not connect to the database: ' . $conn->connect_error);
}

function redirectWithMessage($message, $type, $location) {
    $_SESSION['message'] = $message;
    echo "<script>
            Swal.fire({
                title: '$type',
                text: '$message',
                icon: '" . ($type === 'Success' ? 'success' : 'error') . "',
                confirmButtonText: 'OK'
            }).then(() => {
                window.location.href = '$location';
            });
        </script>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register_btn'])) {
        // Registration logic
        $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
        $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
        $email = mysqli_real_escape_string($conn, $_POST['email2']);
        $password = $_POST['password2'];
        $cpassword = $_POST['cpassword'];

 if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            redirectWithMessage('Invalid email format', 'Error', 'user_login.php');
        }

        $allowed_domain = '@gmail.com'; // Specify the allowed domain here
        if (strpos($email, $allowed_domain) === false) {
            redirectWithMessage('Invalid email domain. Only @gmail.com is allowed', 'Error', 'user_login.php');
        }


        // Check if email is already registered
        $check_email_query = "SELECT email FROM users WHERE email = ?";
        $stmt = mysqli_prepare($conn, $check_email_query);
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            if (mysqli_stmt_num_rows($stmt) > 0) {
                redirectWithMessage('Email is already registered', 'Error', 'user_login.php');
            }
            mysqli_stmt_close($stmt);
        } else {
            redirectWithMessage('Prepared statement error: ' . mysqli_error($conn), 'Error', 'user_login.php');
        }

        // Validate passwords
        if ($password !== $cpassword) {
            redirectWithMessage('Passwords do not match', 'Error', 'user_login.php');
        }

        if (strlen($password) < 8) {
            redirectWithMessage('Password should be at least 8 characters long', 'Error', 'user_login.php');
        }

        if (!preg_match('/[A-Z]/', $password) || !preg_match('/[a-z]/', $password) || !preg_match('/\d/', $password) || !preg_match('/[\W_]/', $password)) {
            redirectWithMessage('Password should contain at least one uppercase letter, one lowercase letter, one number, and one special character', 'Error', 'user_login.php');
        }

        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into database
        $insert_data = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_data);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hashed_password);
            $insert_data_run = mysqli_stmt_execute($stmt);

            if ($insert_data_run) {
                redirectWithMessage('Registered successfully', 'Success', 'user_login.php');
            } else {
                redirectWithMessage('Registration failed: ' . mysqli_error($conn), 'Error', 'user_login.php');
            }

            mysqli_stmt_close($stmt);
        } else {
            redirectWithMessage('Prepared statement error: ' . mysqli_error($conn), 'Error', 'user_login.php');
        }
    } elseif (isset($_POST['login_btn'])) {
        // Login logic
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        if ($stmt === false) {
            die('Prepare failed: ' . htmlspecialchars($conn->error));
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $userdata = $result->fetch_assoc();
            $db_email = $userdata['email'];
            $db_password = $userdata['password']; // Assuming this is a hashed password

            // Verify password
            if (password_verify($password, $db_password)) {
                $_SESSION['user_id'] = $userdata['user_id']; // Assuming 'user_id' is the unique identifier
                $_SESSION['email'] = $db_email;

                redirectWithMessage('Logged in successfully', 'Success', 'user_home.php');
            } else {
                redirectWithMessage('Invalid Password', 'Error', 'user_login.php');
            }
        } else {
            redirectWithMessage('Invalid Email', 'Error', 'user_login.php');
        }
    } else {
        // Invalid request method
        redirectWithMessage('Invalid request method', 'Error', 'user_login.php');
    }
} else {
    // Redirect to login page if accessed directly
    redirectWithMessage('Access denied', 'Error', 'user_login.php');
}
?>


    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</body>
</html>
