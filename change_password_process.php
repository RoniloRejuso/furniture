<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <!-- Custom CSS -->
    <style>
        .error {
            color: red;
            font-size: 12px;
            display: none;
        }
        .red-border {
            border-color: red;
            background-color: #ffcccc; /* Light red background color */
        }
    </style>
</head>
<body style="background-color: beige;">

<?php
include('dbcon.php');

if ($conn->connect_error) {
    die('Could not connect to the database');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['change'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $new_password = trim(mysqli_real_escape_string($conn, $_POST['new_password']));

    // Initialize error variable
    $error = null;

    // Validate password
    if (strlen($new_password) < 7 || (!preg_match('/[0-9]/', $new_password) && !preg_match('/[\W_]/', $new_password))) {
        $error = "Password must be at least 7 characters long and contain at least one special character or number.";
    } else {
        // Check if the username exists
        $checkQuery = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $checkQuery->bind_param('s', $username);
        $checkQuery->execute();
        $result = $checkQuery->get_result();

        if ($result->num_rows > 0) {
            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the password in the database
            $changeQuery = $conn->prepare("UPDATE admin SET password = ? WHERE username = ?");
            $changeQuery->bind_param('ss', $hashed_password, $username);
            $changeQuery->execute();

            if ($changeQuery->affected_rows > 0) {
                // Password updated successfully
                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
                echo "<script>
                    Swal.fire({
                        title: 'Success',
                        text: 'Password updated successfully!',
                        icon: 'success',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'login.php';
                        }
                    });
                </script>";
            } else {
                // Failed to update password
                $error = "Failed to update password.";
            }
        } else {
            // Username does not exist
            $error = "Username does not exist.";
        }

        $checkQuery->close();
    }

    if ($error !== null) {
        // Display error message using SweetAlert
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                title: 'Error',
                text: '$error',
                icon: 'error',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'change_password.php';
                }
            });
        </script>";
    }
} else {
    // Invalid request method
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>
        Swal.fire({
            title: 'Error',
            text: 'Invalid request method',
            icon: 'error',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'change_password.php';
            }
        });
    </script>";
}

$conn->close();
?>

<<<<<<< HEAD

<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
=======
>>>>>>> 17a20228005d2339de0a3d25e155d42fa8040180
>>>>>>> b68a38d76038cea4c49156dfeafeb59dd52b37c8
>>>>>>> b6b93d693c913d05296d8548b7e741bd2bd6313e
>>>>>>> cbc680c9ba4b9d5710445edd16ae8fb866fcf4ab
<!-- Optional: Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-zGS6E7LOZB7z7jcN6m+AaA6JwwrK/ZpNqY0d9N5/RwH+LZ1OQVpZf3ZlLwJ4yD2r" crossorigin="anonymous"></script>
</body>
</html>
