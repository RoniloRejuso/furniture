<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link href="assets/css/signup.css" rel="stylesheet">
    <link rel="icon" href="images/icon.png">
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
        .logcontrol-group {
            position: relative;
            margin-bottom: 1em;
        }
        .toggle-password {
            position: absolute;
            top: 35%;
            right: 90px; /* Adjust for alignment */
            transform: translateY(-50%);
            cursor: pointer;
            color: gray;
            display: none; /* Hide initially */
        }
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
<body>
    <div class="logcontainer">
        <div class="logterry">
            <div class="logo">
                <h1 class="m-0 text-primary" style="color: #ffd698;">Sign up</h1>
            </div>

            <form method="post" class="form-horizontal" action="signup.php" onsubmit="return validateForm()">
                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="username"></label>
                    <div class="logcontrols">
                        <input type="text" name="username" id="username" placeholder="Enter Username" maxlength="50" required>
                        <span id="username-error" class="error">Username cannot be purely numerical.</span>
                    </div>
                </div>

                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="email"></label>
                    <div class="logcontrols">
                        <input type="email" name="email" id="email" placeholder="Enter Email" required>
                        <small id="emailValidationError" class="form-text text-danger" style="display:none;">Invalid email format or domain does not exist.</small>
                    </div>
                </div>

                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="password"></label>
                    <div class="logcontrols">
                        <input type="password" name="password" id="password" placeholder="Enter Password" maxlength="10" required>
                        <i class="fas fa-eye toggle-password" id="toggle-password" onclick="togglePassword('password')"></i>
                        <span id="password-error" class="error">Password cannot be purely numerical or purely lowercase letters.</span>
                    </div>
                </div>

                <div class="logcontrol-group">
                    <label class="logcontrol-label" for="confirmPassword"></label>
                    <div class="logcontrols">
                        <input type="password" name="confirm_password" id="confirmPassword" placeholder="Confirm Password" maxlength="10" required>
                        <i class="fas fa-eye toggle-password" id="toggle-confirm-password" onclick="togglePassword('confirmPassword')"></i>
                        <small id="passwordError" class="error" style="display:none;color:red;">Passwords do not match</small>
                    </div>
                </div>

                <?php if (isset($error)): ?>
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
                <img src="assets/img/FurniView.png" alt="" style="width: 200px; height: auto; margin-top: 5px; margin-left: 30px;">
            </form>

            <script>
                function togglePassword(fieldId) {
                    const field = document.getElementById(fieldId);
                    const fieldType = field.getAttribute('type') === 'password' ? 'text' : 'password';
                    field.setAttribute('type', fieldType);
                }

                function showHideEyeIcon() {
                    const passwordField = document.getElementById('password');
                    const confirmPasswordField = document.getElementById('confirmPassword');
                    const passwordEyeIcon = document.getElementById('toggle-password');
                    const confirmPasswordEyeIcon = document.getElementById('toggle-confirm-password');

                    passwordEyeIcon.style.display = passwordField.value.trim() ? 'block' : 'none';
                    confirmPasswordEyeIcon.style.display = confirmPasswordField.value.trim() ? 'block' : 'none';
                }

                document.getElementById('password').addEventListener('input', function () {
                    showHideEyeIcon();
                    this.value = this.value.replace(/\s/g, '');
                    validatePassword();
                });

                document.getElementById('confirmPassword').addEventListener('input', function () {
                    showHideEyeIcon();
                    this.value = this.value.replace(/\s/g, '');
                    validatePasswordMatch();
                });

                function validatePassword() {
                    const password = document.getElementById('password').value;
                    const passwordStrengthError = document.getElementById('passwordStrengthError');
                    const regex = /^(?=.*[A-Z!@#$%^&*(),.?":{}|<>]).{6,}$/;
                    if (!regex.test(password)) {
                        passwordStrengthError.style.display = 'block';
                    } else {
                        passwordStrengthError.style.display = 'none';
                    }
                }

                function validatePasswordMatch() {
                    const password = document.getElementById('password').value;
                    const confirmPassword = document.getElementById('confirmPassword').value;
                    const passwordError = document.getElementById('passwordError');
                    if (password !== confirmPassword) {
                        passwordError.style.display = 'block';
                    } else {
                        passwordError.style.display = 'none';
                    }
                }

                function validateForm() {
                    validatePassword();
                    validatePasswordMatch();

                    const passwordStrengthError = document.getElementById('passwordStrengthError');
                    const passwordError = document.getElementById('passwordError');

                    if (passwordStrengthError.style.display === 'block' || passwordError.style.display === 'block') {
                        return false;
                    }

                    return true;
                }

                function togglePassword(fieldId) {
                    const field = document.getElementById(fieldId);
                    field.type = field.type === 'password' ? 'text' : 'password';
                }

                document.getElementById('username').addEventListener('input', function () {
                    this.value = this.value.replace(/\s/g, '');
                    var usernameInput = document.getElementById('username');
                    var usernameError = document.getElementById('username-error');
                    var usernameValue = usernameInput.value;

                    if (/^\d+$/.test(usernameValue)) {  // Check if the input is purely numerical
                        usernameInput.classList.add('red-border');
                        usernameError.style.display = 'block';
                    } else {
                        usernameInput.classList.remove('red-border');
                        usernameError.style.display = 'none';
                    }
                });

                document.getElementById('password').addEventListener('input', function () {
                    var passwordInput = document.getElementById('password');
                    var passwordError = document.getElementById('password-error');
                    var passwordValue = passwordInput.value;

                    if (/^\d+$/.test(passwordValue) || /^[a-z]+$/.test(passwordValue)) {  // Check if the input is purely numerical or purely lowercase letters
                        passwordInput.classList.add('red-border');
                        passwordError.style.display = 'block';
                    } else {
                        passwordInput.classList.remove('red-border');
                        passwordError.style.display = 'none';
                    }
                });

                var knownDomains = ["gmail.com", "yahoo.com", "outlook.com", "hotmail.com"];

                function validateEmail(input, errorElement) {
                    var emailValue = input.value.trim();
                    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    var emailParts = emailValue.split("@");
                    var domainExists = emailParts.length === 2 && knownDomains.includes(emailParts[1]);
                    var firstChar = emailValue.charAt(0);

                    if (emailValue === "") {
                        input.classList.remove('red-border');
                        errorElement.style.display = 'none';
                    } else if (!isNaN(firstChar)) {
                        input.classList.add('red-border');
                        errorElement.style.display = 'none'; // Do not show error message for first character check
                    } else if (emailValue.includes("@") && emailValue.includes(".") && (!emailPattern.test(emailValue) || !domainExists)) {
                        input.classList.add('red-border');
                        errorElement.style.display = 'block';
                    } else {
                        input.classList.remove('red-border');
                        errorElement.style.display = 'none';
                    }
                }

                document.getElementById('email').addEventListener('input', function () {
                    var emailInput = document.getElementById('email');
                    var emailError = document.getElementById('emailValidationError');
                    validateEmail(emailInput, emailError);
                });

                document.querySelector('form').addEventListener('submit', function (event) {
                    var emailInput = document.getElementById('email');
                    var emailError = document.getElementById('emailValidationError');
                    var emailValue = emailInput.value.trim();
                    var emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    var emailParts = emailValue.split("@");
                    var domainExists = emailParts.length === 2 && knownDomains.includes(emailParts[1]);

                    if (!emailPattern.test(emailValue) || !domainExists) {
                        emailInput.classList.add('red-border');
                        emailError.style.display = 'block';
                        event.preventDefault(); // Prevent form submission
                    } else {
                        emailInput.classList.remove('red-border');
                        emailError.style.display = 'none';
                    }
                });

                // Initial check to show or hide toggle icons
                showHideEyeIcon();
            </script>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</body>
</html>
