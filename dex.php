<?php session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Registers</title>

    <script src='sweetalert.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>
<body>

<?php

include('dbcon.php');


if (isset($_POST['register_btn'])) {

    $username = mysqli_real_escape_string($con, $_POST['username']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = mysqli_real_escape_string($con, $_POST['password']);
    $cpassword = mysqli_real_escape_string($con, $_POST['confirm_password']);

    // Check if email already exists in the database
    $check_email_query = "SELECT * FROM admin WHERE email = '$email'";
    $check_email_result = mysqli_query($con, $check_email_query);

    if (mysqli_num_rows($check_email_result) > 0) {
        // Email already exists
        $_SESSION['message'] = "Email already exists";
        echo "<script>swal('Email already exists!', { button: 'Enter!' }).then(() => {
            window.location.href = 'signup.php';
        });</script>";
        exit();
    }

    if ($password === $cpassword) {

        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $insert_data = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($con, $insert_data);

        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
            $insert_data_run = mysqli_stmt_execute($stmt);

            if ($insert_data_run) {
                $_SESSION['message'] = "Registered successfully";
                echo "<script>swal('Register Successful!', { button: 'Enter!' }).then(() => {
                    window.location.href = 'login.php';
                });</script>";
                exit();
            } else {
                $_SESSION['message'] = "Registration failed: " . mysqli_error($con);
                echo "<script>swal('Registration failed!', { button: 'Enter!' }).then(() => {
                    window.location.href = 'signup.php';
                });</script>";
                exit();
            }
        } else {
            $_SESSION['message'] = "Prepared statement error: " . mysqli_error($con);
            echo "<script>swal('Registration failed!', { button: 'Enter!' }).then(() => {
                window.location.href = 'signup.php';
            });</script>";
            exit();
        }
    } else {
        $_SESSION['message'] = "Passwords do not match";
        echo "<script>swal('Passwords do not match!', { button: 'Enter!' }).then(() => {
            window.location.href = 'signup.php';
        });</script>";
        exit();
    }
}

else if (isset($_POST['login_btn'])) {
    // Escape the input to prevent SQL injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userdata = $result->fetch_assoc();
        $db_username = $userdata['username'];
        $db_password = $userdata['password']; // Assuming this is a hashed password
        $role_as = $userdata['is_admin']; // Assuming 'is_admin' contains '1' for admin and '0' for staff

        // Verify password
        if (password_verify($password, $db_password)) {
            $_SESSION['admin_id'] = $userdata['admin_id']; // Assuming 'admin_id' is the unique identifier
            $_SESSION['is_admin'] = $role_as;

            if ($role_as == '1') {
                $_SESSION['message'] = "Welcome to Dashboard";
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Welcome to Dashboard',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'admin_index.php';
                    });
                </script>";
                exit();
            } else {
                $_SESSION['message'] = "Logged in successfully";
                echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Logged in successfully',
                        icon: 'success'
                    }).then(() => {
                        window.location.href = 'admin_index.php';
                    });
                </script>";
                exit();
            }
        } else {
            $_SESSION['message'] = "Invalid Password";
            echo "<script>
                Swal.fire({
                    title: 'Login Failed!',
                    text: 'Invalid Password',
                    icon: 'error'
                }).then(() => {
                    window.location.href = 'login.php';
                });
            </script>";
            exit();
        }
    } else {
        $_SESSION['message'] = "Invalid Username";
        echo "<script>
            Swal.fire({
                title: 'Login Failed!',
                text: 'Invalid Username',
                icon: 'error'
            }).then(() => {
                window.location.href = 'login.php';
            });
        </script>";
        exit();
    }
}

?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>
