<?php
session_start();
include('dbcon.php');

if (isset($_POST['submit_reset'])) {
    $token = $_GET['token'];
    $current_password = mysqli_real_escape_string($conn, $_POST['current_password']);
    $new_password = mysqli_real_escape_string($conn, $_POST['new_password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Check if the token exists in the database
    $query = "SELECT * FROM admin WHERE reset_token=?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify current password
        if (password_verify($current_password, $row['password'])) {
            // Check if new password matches confirm password
            if ($new_password === $confirm_password) {
                // Update the password and remove the token
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $update_query = "UPDATE admin SET password=?, reset_token=NULL WHERE reset_token=?";
                $update_stmt = mysqli_prepare($conn, $update_query);
                mysqli_stmt_bind_param($update_stmt, "ss", $hashed_password, $token);
                mysqli_stmt_execute($update_stmt);

                // Use JavaScript to show a prompt and redirect
                echo '<script>alert("Password reset successfully. You can now login with your new password."); window.location.href = "login.php";</script>';
                exit; // Stop further execution to prevent HTML rendering
            } else {
                echo '<script>alert("New password and confirm password do not match. Please try again.");</script>';
            }
        } else {
            echo '<script>alert("Invalid current password. Please try again.");</script>';
        }
    } else {
        echo '<script>alert("Invalid or expired token. Please try again.");</script>';
    }
}
?>
<title>E-PIN</title>
<link href="img/tooth.png" rel="icon">
<link href="frontcss/loginstyle.css" rel="stylesheet">

<!-- HTML Form for Reset Password -->
<div class="logcontainer">
    <div class="margin-top" style="margin-bottom: 250px;">
        <div class="row">
            <div class="span12">
                <div class="logbox">
                    <div class="logterry">
                        <h1 class="m-0 text-primary"><img src="img/logo.png" class="logo-img" width="250px" alt="Logo"></h1>
                        <form method="post" class="form-horizontal">
                            <div class="logcontrol-group">
                                <label class="logcontrol-label" for="inputPassword"></label>
                                <div class="logcontrols">
                                    <input type="password" name="current_password" placeholder="Current Password" required>
                                </div>
                            </div>
                            <div class="logcontrol-group">
                                <label class="logcontrol-label" for="inputPassword"></label>
                                <div class="logcontrols">
                                    <input type="password" name="new_password" placeholder="New Password" required>
                                </div>
                            </div>
                            <div class="logcontrol-group">
                                <label class="logcontrol-label" for="inputPassword"></label>
                                <div class="logcontrols">
                                    <input type="password" name="confirm_password" placeholder="Confirm Password" required>
                                </div>
                            </div>
                            <div class="logcontrol-group">
                                <div class="logcontrols">
                                    <button name="submit_reset" type="submit" class="btn btn-info">
                                        <i class="icon-refresh icon-large"></i>&nbsp;<b>Reset Password</b>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="frontfooter">
<p style="color: #520049;">&copy; <b>E-PIN</b>. All Rights Reserved.</p>
</div>
