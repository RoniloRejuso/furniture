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
        right: 80px;
        transform: translateY(-50%);
        cursor: pointer;
        display: none; /* Initially hidden */
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
                        <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('password')"></i>
                    </div>
                </div>

                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="confirmPassword"></label>
                    <div class="logcontrols">
                        <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" maxlength="10" required>
                        <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('confirmPassword')"></i>
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

                // Show eye icon when there's input in password fields
                document.getElementById('password').addEventListener('input', showEyeIcon);
                document.getElementById('confirmPassword').addEventListener('input', showEyeIcon);

                function showEyeIcon() {
                    const passwordValue = document.getElementById('password').value;
                    const confirmPasswordValue = document.getElementById('confirmPassword').value;
                    const eyeIcons = document.querySelectorAll('.toggle-password');

                    eyeIcons.forEach(icon => {
                        if (passwordValue !== '' || confirmPasswordValue !== '') {
                            icon.style.display = 'inline-block';
                        } else {
                            icon.style.display = 'none';
                        }
                    });
                }
            </script>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>