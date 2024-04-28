<?php
include('dbcon.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Home</title>
    <link href="assets/css/login.css" rel="stylesheet">
    
</head>
<style>
    body {
            background-image: url('assets/img/ourhome.jpg');
            background-size: cover;
            position: relative;
        }
</style>
<body>    
    <div class="logcontainer">
        <div class="logterry">
            <div class="logo">
            <h1 class="m-0 text-primary" style="color: #ffd698;">Log in</h1>
            </div>

            <form method="post" class="form-horizontal">
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="inputUsername"></label>
                    <div class="logcontrols">
                        <input type="text" name="username" placeholder="Enter Username" required>
                    </div>
                </div>
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="inputPassword"></label>
                    <div class="logcontrols">
                        <input type="password" name="password" id="password" placeholder="Enter Password" required>
                        <span toggle="#password" class="field-icon toggle-password">
                            <img src="assets/img/icons/eye1.svg" alt="Toggle Password Visibility">
                        </span>
                    </div>
                    <?php
session_start();
include('dbcon.php');

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

                    <a href="forgot_password.php" style="margin-left: 320px; color: #ffd698;">Forgot Your Password?</a>
                </div>
                <div class="logcontrol-group">
                    <div class="logcontrols">
                        <button name="submit1" type="submit" style="text-align: left;" class="btn btn-info">
                            <span style="float: right; margin-right:10px;">&#9654;</span>
                            <b style="margin-left:15px;"><big>LOG IN</big></b>
                        </button>
                     </div>
                     <a href="signup.php" style="color: #ffd698;"><small>Sign-Up</small></a>
                </div>
                <img src="assets/img/our home.png" alt="" style="width: 200px; height: auto; margin-top: 5px; margin-left: 30px;">
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(".toggle-password").click(function() {
            $(this).toggleClass("show-password");
            var input = $($(this).attr("toggle"));
            if (input.attr("type") === "password") {
                input.attr("type", "text");
            } else {
                input.attr("type", "password");
            }
        });
    </script>
</body>
</html>