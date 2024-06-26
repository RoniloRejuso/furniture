<?php session_start();
include('dbcon.php');

if(isset($_POST['submit1'])) {
    $username = trim(mysqli_real_escape_string($conn, $_POST['username']));
    $email = trim(mysqli_real_escape_string($conn, $_POST['email']));
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    $confirm_password = trim(mysqli_real_escape_string($conn, $_POST['confirm_password']));

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format";
    } 
    // Check if passwords match
    elseif($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert user into database
        $query = "INSERT INTO admin (username, email, password) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sss", $username, $email, $hashed_password);
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
    <title>Sign Up</title>
    <link href="assets/css/signup.css" rel="stylesheet">
</head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body {
            background-image: url('assets/img/ourhome.jpg');
            background-size: cover;
            position: relative;
        }
        .input-group {
      margin-bottom: 1em;
    }
    input[type="password"].password-input.invalid {
      border-color: red !important;
    }
    input[type="password"].password-input.valid {
      border-color: green !important;
    }
    .error {
    border-color: red;
}
.form-text.text-danger {
    color: red;
}
.logcontrol-group {
            position: relative;
            margin-bottom: 1em;
        }
        .toggle-password {
            position: absolute;
            top: 43%;
            right: 50px;
            transform: translateY(-50%);
            cursor: pointer;
        }

</style>
<body>    
    <div class="logcontainer">
        <div class="logterry">
            <div class="logo">
                <h1 class="m-0 text-primary" style="color: #ffd698;">Sign up</h1>
            </div>
            <form method="post" class="form-horizontal"  action="signup.php">
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="inputUsername"></label>
                    <div class="logcontrols">
                        <input type="text" name="username" placeholder="Enter Username" maxlength="50" required>
                    </div>
                </div>
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="inputEmail"></label>
                    <div class="logcontrols">
                        <input type="email" name="email" placeholder="Enter Email" placeholder="example@email.com" required>
                    </div>
                </div>
                
                <div class="logcontrol-group">
    <label class="logcontrol-label" for="inputPassword"></label>
    <div class="logcontrols">
    <input type="password" name="password" id="password" placeholder="Enter Password" maxlength="10" required>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
    </div>
</div>

<div class="logcontrol-group">
    <label class="logcontrol-label" for="confirmPassword"></label>
    <div class="logcontrols">
    <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" maxlength="10" required>
            <i class="fas fa-eye toggle-password" onclick="togglePassword('confirmPassword')"></i>
        <small id="passwordError" class="form-text text-danger" style="display:none;">Passwords do not match</small>
    </div>
</div>
                
                <?php if(isset($error)): ?>
                    <div class="alert alert-danger" style="color: red;"><strong>Error:</strong> <?php echo $error; ?></div>
                <?php endif; ?>
                <div class="logcontrol-group">
                    <div class="logcontrols">
                        <button name="submit1" type="submit" style="text-align: left;" class="btn btn-info">
                            <span style="float: right; margin-right:10px;">&#9654;</span>
                            <b style="margin-left:15px;"><big>Sign Up</big></b>
                        </button>                   
                    </div>
                    <a href="login.php" style="color: #ffd698;"><small>Log In</small></a>
                </div>
                <img src="assets/img/our home.png" alt="" style="width: 200px; height: auto; margin-top: 5px; margin-left: 30px;">
            </form>


            <script>
    document.getElementById('password').addEventListener('input', validatePasswords);
    document.getElementById('confirmPassword').addEventListener('input', validatePasswords);

    function validatePasswords() {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        var passwordError = document.getElementById('passwordError');

        if (password !== confirmPassword) {
            document.getElementById('confirmPassword').classList.add('error');
            passwordError.style.display = 'block';
        } else {
            document.getElementById('confirmPassword').classList.remove('error');
            passwordError.style.display = 'none';
        }
    }
</script>
<script>
        function togglePassword(id) {
            const passwordField = document.getElementById(id);
            const eyeIcon = passwordField.nextElementSibling;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>