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

if (isset($_POST['register_btn'])) {
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);

    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $check_email_result = mysqli_query($conn, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        $_SESSION['message'] = "Email already exists";
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Email already exists!',
                icon: 'error',
                confirmButtonText: 'Enter'
            }).then(() => {
                window.location.href = 'user_login.php';
            });
        </script>";
        exit();
    }

    if ($password === $cpassword) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_data = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $insert_data);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $firstname, $lastname, $email, $hashed_password);
            $insert_data_run = mysqli_stmt_execute($stmt);

            if ($insert_data_run) {
                $_SESSION['message'] = "Registered successfully";
                echo "<script>
                    Swal.fire({
                        title: 'Success',
                        text: 'Register Successful!',
                        icon: 'success',
                        confirmButtonText: 'Enter'
                    }).then(() => {
                        window.location.href = 'user_login.php';
                    });
                </script>";
                exit();
            } else {
                $_SESSION['message'] = "Registration failed: " . mysqli_error($con);
                echo "<script>
                    Swal.fire({
                        title: 'Error',
                        text: 'Registration failed!',
                        icon: 'error',
                        confirmButtonText: 'Enter'
                    }).then(() => {
                        window.location.href = 'signup.php';
                    });
                </script>";
                exit();
            }
        } else {
            $_SESSION['message'] = "Prepared statement error: " . mysqli_error($con);
            echo "<script>
                Swal.fire({
                    title: 'Error',
                    text: 'Prepared statement error!',
                    icon: 'error',
                    confirmButtonText: 'Enter'
                }).then(() => {
                    window.location.href = 'signup.php';
                });
            </script>";
            exit();
        }
    } else {
        $_SESSION['message'] = "Passwords do not match";
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: 'Passwords do not match!',
                icon: 'error',
                confirmButtonText: 'Enter'
            }).then(() => {
                window.location.href = 'signup.php';
            });
        </script>";
        exit();
    }
}

else if (isset($_POST['login_btn'])) {
    // Escape the input to prevent SQL injection
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

            $_SESSION['message'] = "Logged in successfully";
            echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Logged in successfully',
                    icon: 'success'
                }).then(() => {
                    window.location.href = 'user_home.php';
                });
            </script>";
            exit();
        } else {
            $_SESSION['message'] = "Invalid Password";
            echo "<script>
                Swal.fire({
                    title: 'Login Failed!',
                    text: 'Invalid Password',
                    icon: 'error'
                }).then(() => {
                    window.location.href = 'user_login.php';
                });
            </script>";
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid Email";
        echo "<script>
            Swal.fire({
                title: 'Login Failed!',
                text: 'Invalid Email',
                icon: 'error'
            }).then(() => {
                window.location.href = 'user_login.php';
            });
        </script>";
        exit();
    }
}
?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</body>
</html>
