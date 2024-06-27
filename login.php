<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Home</title>
    <link href="assets/css/login.css" rel="stylesheet">
    <!-- Add Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
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
                <h1 class="m-0 text-primary" style="color: #ffd698;">Log in</h1>
            </div>

            <form method="post" class="form-horizontal" action="dex.php">
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="inputUsername"></label>
                    <div class="logcontrols">
                        <input type="text" name="username" id="username" placeholder="Enter Username" maxlength="50" required>
                    </div>
                </div>
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="inputPassword"></label>
                    <div class="logcontrols">
                        <input type="password" name="password" id="password" placeholder="Enter Password" maxlength="10" required>
                        <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('password')"></i>
                    </div>
                    <a href="change_pass.php" style="margin-left: 250px; color: #ffd698;">Forgot Password?</a>
                </div>
                <div class="logcontrol-group">
                    <div class="logcontrols">
                        <button name="login_btn" type="submit" style="text-align: left;" class="btn btn-info">
                            <span style="float: right; margin-right:10px;">&#9654;</span>
                            <b style="margin-left:15px;"><big>LOG IN</big></b>
                        </button>
                    </div>

                    <script>
        document.getElementById('username').addEventListener('input', function (e) {
            this.value = this.value.replace(/\s/g, '');
        });
        document.getElementById('password').addEventListener('input', function (e) {
            this.value = this.value.replace(/\s/g, '');
        });

    </script>
                    <a href="signup.php" style="color: #ffd698;"><small>Sign-Up</small></a>
                </div>
                <img src="assets/img/our home.png" alt="" style="width: 200px; height: auto; margin-top: 5px;">
            </form>

        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
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

        document.getElementById('password').addEventListener('input', showHideEyeIcon);

        function showHideEyeIcon() {
            const passwordValue = document.getElementById('password').value;
            const eyeIcon = document.querySelector('.toggle-password');
            if (passwordValue.trim() !== '') {
                eyeIcon.style.display = 'block'; // Show eye icon
            } else {
                eyeIcon.style.display = 'none'; // Hide eye icon
            }
        }
    </script>
</body>
</html>
