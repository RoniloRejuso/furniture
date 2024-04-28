<?php session_start();
include('dbcon.php');

if(isset($_POST['submit1'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password']);

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    
    if($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Insert user into database
        $query = "INSERT INTO admin (username, password) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $hashed_password);
        if(mysqli_stmt_execute($stmt)) {
            $_SESSION['id'] = mysqli_insert_id($conn);
            header("Location: login.php");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In</title>
    <link href="assets/css/signup.css" rel="stylesheet">
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
                <h1 class="m-0 text-primary" style="color: #ffd698;">Sign up</h1>
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
                    </div>
                </div>
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="confirmPassword"></label>
                    <div class="logcontrols">
                        <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" required>
                    </div>
                </div>
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger" style="color: red;"><strong>Error:</strong> <?php echo $error; ?></div>
                <?php endif; ?>
                <div class="logcontrol-group">
                    <div class="logcontrols">
                        <button name="submit1" type="submit" style="text-align: left;" class="btn btn-info">
                            <span style="float: right; margin-right:10px;">&#9654;</span>
                            <b style="margin-left:15px;"><big>Sign In</big></b>
                        </button>                   
                    </div>
                    <a href="login.php" style="color: #ffd698;"><small>Log In</small></a>
                </div>
                <img src="assets/img/our home.png" alt="" style="width: 200px; height: auto; margin-top: 5px; margin-left: 30px;">
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
