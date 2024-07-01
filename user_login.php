<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
<style>
    .error {
        border-color: red;
    }
    .form-text.text-danger {
        color: red;
    }
    input[type="password"].password-input.invalid {
        border-color: red !important;
    }
    input[type="password"].password-input.valid {
        border-color: green !important;
    }


    .red-border {
            border-color: red;
        }
        .form-text.text-danger {
            display: none;
            color: red;
        }
        .error-message {
            color: red;
            display: none;
        }
        .error {
            border-color: red !important;
        }
        .error-message {
            color: red;
            display: none;
        }
        .form-control.error {
            border-color: red !important; /* Ensure red border for form-control elements */
        }



    .form-group {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        top: 70%; /* Adjust as needed to center vertically */
        right: 10px; /* Adjust as needed to position */
        transform: translateY(-50%);
        cursor: pointer;
    }
</style>



<body>
<?php
include 'user_body.php';
?>

    <div class="second_header_section">
        <div class="container-fluid">
            <nav class="navbar navbar-light bg-light">
                <a href="user_index.php" class="continue-shopping"><i class="fas fa-arrow-left"></i> Continue Shopping</a>
            </nav>
        </div>
    </div>

    <div class="login_section">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                    <form id="loginForm" method="POST" action="user_dex.php">

                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" maxlength="50" required>
                        <div id="emailNumberError1" class="error-message">Email should not start with a number.</div>
                        <div id="emailFormatError1" class="error-message">Invalid email format.</div>
                    </div>

                        
                        <div class="form-group">
                            <label for="password">Password:</label>
                            <i class="fas fa-eye toggle-password" onclick="togglePassword('password')"></i>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" maxlength="10" required>
                        </div>
                        <button type="submit" class="btn btn-primary" id="login_btn" name="login_btn">Login</button>
                        <a href="user_change_pass.php">Forgot Password?</a>
                        <div class="or-divider">
                            <span class="divider-line"></span> OR <span class="divider-line"></span>
                        </div>
                        <button type="button" class="btn btn-custom-color" data-toggle="modal" data-target="#signupModal">Create Account</button>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
    function togglePassword(fieldId) {
        const passwordField = document.getElementById(fieldId);
        const toggleBtn = document.querySelector(`#${fieldId} + .toggle-password`);

        if (passwordField.type === 'password') {
            passwordField.type = 'text';
            toggleBtn.classList.add('fa-eye-slash');
            toggleBtn.classList.remove('fa-eye');
        } else {
            passwordField.type = 'password';
            toggleBtn.classList.remove('fa-eye-slash');
            toggleBtn.classList.add('fa-eye');
        }
    }

    document.getElementById('email').addEventListener('input', function () {
        this.value = this.value.replace(/\s/g, '');
    });

    document.getElementById('password').addEventListener('input', function () {
        this.value = this.value.replace(/\s/g, '');
    });

    document.getElementById('email').addEventListener('blur', validateEmail);
    document.getElementById('password').addEventListener('input', validatePassword);

    function validateEmail() {
        const emailInput = document.getElementById('email');
        const emailNumberError = document.getElementById('emailNumberError1');
        const emailFormatError = document.getElementById('emailFormatError1');
        const emailValue = emailInput.value.trim();
        const startsWithNumber = /^[0-9]/.test(emailValue);
        const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);

        if (emailValue === '') {
            emailInput.classList.remove('error');
            emailNumberError.style.display = 'none';
            emailFormatError.style.display = 'none';
        } else if (startsWithNumber) {
            emailInput.classList.add('error');
            emailNumberError.style.display = 'block';
            emailFormatError.style.display = 'none';
        } else if (emailValue && !isValidEmail) {
            emailInput.classList.add('error');
            emailNumberError.style.display = 'none';
            emailFormatError.style.display = 'block';
        } else {
            emailInput.classList.remove('error');
            emailNumberError.style.display = 'none';
            emailFormatError.style.display = 'none';
        }

        // Toggle error class based on error message display
        emailInput.classList.toggle('error', emailNumberError.style.display === 'block' || emailFormatError.style.display === 'block');
    }

    function validatePassword() {
        const passwordInput = document.getElementById('password');
        const passwordError = document.getElementById('passwordError');
        const passwordValue = passwordInput.value.trim();
        const isOnlyNumbers = /^[0-9]+$/.test(passwordValue);

        if (passwordValue === '') {
            passwordInput.classList.remove('error');
            passwordError.style.display = 'none';
        } else if (isOnlyNumbers) {
            passwordInput.classList.add('error');
            passwordError.style.display = 'block';
        } else {
            passwordInput.classList.remove('error');
            passwordError.style.display = 'none';
        }
    }

    function validateForm() {
        validateEmail();
        validatePassword();
    }

    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

    <div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <h3 class="signup-modal-title" style="text-align: center;" id="signupModalLabel"><big>Create Account</big></h3>
  


               <div class="modal-body">

                    <form id="signupForm" method="POST" action="user_dex.php" onsubmit="return validateForm()">
                       
                            <div class="form-group">
                            <label for="firstname">First name:</label>
                            <input type="text" class="form-control" id="firstname" pattern="[A-Za-z ]+" name="firstname" placeholder="Enter first name" maxlength="50" required>
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last name:</label>
                            <input type="text" class="form-control" id="lastname" pattern="[A-Za-z ]+" name="lastname" placeholder="Enter last name" maxlength="50" required>
                        </div>

                        <script>
        document.getElementById('firstname').addEventListener('input', function (event) {
            const pattern = /^[A-Za-z ]+$/;
            event.target.value = event.target.value.replace(/[^A-Za-z ]/g, '');
        });

        document.getElementById('lastname').addEventListener('input', function (event) {
            const pattern = /^[A-Za-z ]+$/;
            event.target.value = event.target.value.replace(/[^A-Za-z ]/g, '');
        });
    </script>

                        
                        <script>
                            function validateInput(inputElement) {
                                var inputValue = inputElement.value.trim();
                                var parts = inputValue.split(/\s+/);
                                for (var i = 0; i < parts.length; i++) {
                                    parts[i] = parts[i].charAt(0).toUpperCase() + parts[i].slice(1).toLowerCase();
                                }
                                var capitalizedValue = parts.join(' ');

                                inputElement.value = capitalizedValue;
                            }

                            document.getElementById("firstname").addEventListener("input", function () {
                                validateInput(this);
                            });

                            document.getElementById("lastname").addEventListener("input", function () {
                                validateInput(this);
                            });
                        </script>

                        <div class="form-group">
                            <label for="email2">Email:</label>
                            <input type="text" class="form-control email-input" id="email2" name="email2" placeholder="Enter your email" maxlength="50" required>
                            <div id="emailNumberError2" class="error-message">Email should not start with a number.</div>
                            <div id="emailFormatError2" class="error-message">Invalid email format.</div>
                        </div>

                        <div class="form-group">
                        <label for="password2">Password:</label>
                        <input type="password" class="form-control password-input" id="password2" name="password2" placeholder="Enter your password" maxlength="10" required>
                        <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('password2')"></i>
                        <div id="passwordError2" class="error-message" style="display:none;">Password should not be only numbers.</div>
                        <div id="passwordStrengthError" class="error-message" style="display:none;">Password is too weak. It should have at least one uppercase letter or special character.</div>
                    </div>

                    <div class="form-group">
                        <label for="cpassword">Confirm Password:</label>
                        <input type="password" class="form-control password-input" id="cpassword" name="cpassword" placeholder="Confirm your password" maxlength="10" required>
                        <i class="fas fa-eye toggle-password" onclick="togglePassword('cpassword')"></i>
                        <small id="passwordMismatchError" class="form-text text-danger" style="display:none;">Passwords do not match</small>
                    </div>

                    <script>
function validatePassword() {
    const passwordField = document.getElementById('password2');
    const passwordStrengthError = document.getElementById('passwordStrengthError');
    const passwordError2 = document.getElementById('passwordError2');
    const password = passwordField.value;

    // Hide all error messages initially
    passwordStrengthError.style.display = 'none';
    passwordError2.style.display = 'none';

    // Check for password length
    if (password.length < 4) {
        return true; // Do not show any error if password is less than 4 characters
    }

    // Check for password strength: all lowercase and no special characters
    if (/^[a-z]+$/.test(password)) {
        passwordStrengthError.style.display = 'block';
        return false;
    }
    
    return true;
}

function checkPasswordMatch() {
    const passwordField = document.getElementById('password2');
    const confirmPasswordField = document.getElementById('cpassword');
    const passwordMismatchError = document.getElementById('passwordMismatchError');

    // Hide error message initially
    passwordMismatchError.style.display = 'none';

    // Check if passwords match
    if (passwordField.value !== confirmPasswordField.value) {
        passwordMismatchError.style.display = 'block';
        return false;
    }

    return true;
}

document.getElementById('password2').addEventListener('input', validatePassword);
document.getElementById('cpassword').addEventListener('input', checkPasswordMatch);

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
    }
}
</script>
                    <script>
function validatePassword() {
    const passwordField = document.getElementById('password2');
    const passwordStrengthError = document.getElementById('passwordStrengthError');
    const passwordError2 = document.getElementById('passwordError2');
    const password = passwordField.value;

    // Hide all error messages initially
    passwordStrengthError.style.display = 'none';
    passwordError2.style.display = 'none';

    // Check for password length
    if (password.length < 4) {
        return true; // Do not show any error if password is less than 4 characters
    }

    // Check for password strength: all lowercase and no special characters
    if (/^[a-z]+$/.test(password)) {
        passwordStrengthError.style.display = 'block';
        return false;
    }
    
    return true;
}

document.getElementById('password2').addEventListener('input', validatePassword);

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
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
                    
<script>
    // Function to prevent spaces in the input fields
    function preventSpaces(event) {
        if (event.keyCode === 32) {
            event.preventDefault();
        }
    }

    // Select all password inputs and add event listeners to prevent spaces
    document.querySelectorAll('.password-input').forEach(function(input) {
        input.addEventListener('keydown', preventSpaces);
    });

    // Function to validate password fields
    function validatePassword() {
        const password = document.getElementById('password').value.trim();
        const cpassword = document.getElementById('cpassword').value.trim();
        const passwordError = document.getElementById('passwordError');

        if (password === '' || cpassword === '') {
            passwordError.style.display = 'none';
        } else if (password !== cpassword) {
            passwordError.style.display = 'block';
        } else {
            passwordError.style.display = 'none';
        }
    }

    // Add event listeners to password fields for validation
    document.getElementById('password').addEventListener('input', validatePassword);
    document.getElementById('cpassword').addEventListener('input', validatePassword);

    // Function to validate all email fields
    function validateEmail() {
        document.querySelectorAll('.email-input').forEach(function(emailInput) {
            const emailNumberError = document.getElementById(emailInput.id.replace('email', 'emailNumberError'));
            const emailFormatError = document.getElementById(emailInput.id.replace('email', 'emailFormatError'));
            const emailValue = emailInput.value.trim();
            const startsWithNumber = /^[0-9]/.test(emailValue);
            const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);

            if (emailValue === '') {
                emailInput.classList.remove('error');
                emailNumberError.style.display = 'none';
                emailFormatError.style.display = 'none';
            } else if (startsWithNumber) {
                emailInput.classList.add('error');
                emailNumberError.style.display = 'block';
                emailFormatError.style.display = 'none';
            } else if (emailValue && !isValidEmail) {
                emailInput.classList.add('error');
                emailNumberError.style.display = 'none';
                emailFormatError.style.display = 'block';
            } else {
                emailInput.classList.remove('error');
                emailNumberError.style.display = 'none';
                emailFormatError.style.display = 'none';
            }

            // Toggle error class based on error message display
            emailInput.classList.toggle('error', emailNumberError.style.display === 'block' || emailFormatError.style.display === 'block');
        });
    }

    // Add event listeners to all email fields for validation
    document.querySelectorAll('.email-input').forEach(function(emailInput) {
        emailInput.addEventListener('blur', validateEmail);
    });

    // Function to validate the form before submission
    function validateForm() {
        validateEmail();
        validatePassword();
    }

    // Function to toggle password visibility
    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>


                        <script>
    // Function to prevent spaces in the input fields
    function preventSpaces(event) {
        if (event.keyCode === 32) {
            event.preventDefault();
        }
    }

    // Select all email and password inputs and add event listeners
    document.querySelectorAll('.email-input, .password-input').forEach(function(input) {
        input.addEventListener('keydown', preventSpaces);
    });

    // Validate all email fields
    function validateEmail() {
        document.querySelectorAll('.email-input').forEach(function(emailInput) {
            const emailNumberError = document.getElementById(emailInput.id.replace('email', 'emailNumberError'));
            const emailFormatError = document.getElementById(emailInput.id.replace('email', 'emailFormatError'));
            const emailValue = emailInput.value.trim();
            const startsWithNumber = /^[0-9]/.test(emailValue);
            const isValidEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailValue);

            if (emailValue === '') {
                emailInput.classList.remove('error');
                emailNumberError.style.display = 'none';
                emailFormatError.style.display = 'none';
            } else if (startsWithNumber) {
                emailInput.classList.add('error');
                emailNumberError.style.display = 'block';
                emailFormatError.style.display = 'none';
            } else if (emailValue && !isValidEmail) {
                emailInput.classList.add('error');
                emailNumberError.style.display = 'none';
                emailFormatError.style.display = 'block';
            } else {
                emailInput.classList.remove('error');
                emailNumberError.style.display = 'none';
                emailFormatError.style.display = 'none';
            }

            // Toggle error class based on error message display
            emailInput.classList.toggle('error', emailNumberError.style.display === 'block' || emailFormatError.style.display === 'block');
        });
    }

    // Validate all password fields
    function validatePassword() {
        document.querySelectorAll('.password-input').forEach(function(passwordInput) {
            const passwordError = document.getElementById(passwordInput.id.replace('password', 'passwordError'));
            const passwordValue = passwordInput.value.trim();
            const isOnlyNumbers = /^[0-9]+$/.test(passwordValue);

            if (passwordValue === '') {
                passwordInput.classList.remove('error');
                passwordError.style.display = 'none';
            } else if (isOnlyNumbers) {
                passwordInput.classList.add('error');
                passwordError.style.display = 'block';
            } else {
                passwordInput.classList.remove('error');
                passwordError.style.display = 'none';
            }
        });
    }

    // Add event listeners to all email and password fields for validation
    document.querySelectorAll('.email-input').forEach(function(emailInput) {
        emailInput.addEventListener('blur', validateEmail);
    });
    document.querySelectorAll('.password-input').forEach(function(passwordInput) {
        passwordInput.addEventListener('input', validatePassword);
    });

    function validateForm() {
        validateEmail();
        validatePassword();
    }

    function togglePassword(id) {
        const input = document.getElementById(id);
        const icon = input.nextElementSibling;
        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }
</script>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" name="acceptTerms">
                            <label class="form-check-label" for="acceptTerms">I agree and consent to the collection, use or otherwise processing of my personal data by Casamia Furniture Center, Inc. (“Our Home”) and its service group. I agree to be bound by the Website’s Terms of Service and Privacy Notice.</label>
                        </div>

                        <button type="submit" class="btn btn-create-account mt-3" name="register_btn" id="register_btn">Create</button>
                    </form>

                    <script>
        function validateForm() {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailValue = emailInput.value;
            const passwordValue = passwordInput.value;

            // Reset error classes
            emailInput.classList.remove('error');
            passwordInput.classList.remove('error');

            // Email validation
            if (emailValue.match(/^[0-9]/) || !validateEmail(emailValue)) {
                emailInput.classList.add('error');
            }

            // Password validation
            if (passwordValue.match(/^[0-9]+$/)) {
                passwordInput.classList.add('error');
            }
        }

        function validateEmail(email) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(email);
        }

        function togglePassword(id) {
            const input = document.getElementById(id);
            const icon = input.nextElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

                    <script>
                        // Email Validation
                        function validateEmail(inputElement) {
                            const emailValue = inputElement.value;
                            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                            if (!emailRegex.test(emailValue)) {
                                inputElement.classList.add('error');
                            } else {
                                inputElement.classList.remove('error');
                            }
                        }

                        document.getElementById('signupEmail').addEventListener('input', function () {
                            validateEmail(this);
                        });

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

                        document.querySelectorAll('input[type="password"]').forEach((passwordField) => {
                            passwordField.addEventListener('input', function() {
                                const toggleIcon = passwordField.nextElementSibling;
                                if (passwordField.value.trim() === '') {
                                    toggleIcon.style.display = 'none';
                                } else {
                                    toggleIcon.style.display = 'block';
                                }
                            });
                        });

                        function validateForm() {
                            var acceptTermsCheckbox = document.getElementById("acceptTerms");
                            if (!acceptTermsCheckbox.checked) {
                                alert("Please accept the terms and privacy policies.");
                                return false;
                            }

                            const email = document.getElementById('signupEmail');
                            const password = document.getElementById('npassword');
                            const confirmPassword = document.getElementById('cpassword');

                            // Validate email and password before submitting
                            validateEmail(email);
                            validatePassword(password);

                            // Check if any field has error class
                            if (document.querySelectorAll('.error').length > 0) {
                                alert("Please fix the errors before submitting.");
                                return false;
                            }

                            return true;
                        }
                    </script>


                </div>
            </div>
        </div>
    </div>

    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.0.0.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/owl.carousel.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        function openNav() {
            document.getElementById("mySidenav").style.width = "100%";
        }

        function closeNav() {
            document.getElementById("mySidenav").style.width = "0";
        }

        function toggleDropdown() {
            var dropdownMenu = document.getElementById("furnitureMenu");
            if (dropdownMenu.style.display === "block") {
                dropdownMenu.style.display = "none";
            } else {
                dropdownMenu.style.display = "block";
            }
        }

        document.getElementById("password").addEventListener('input', function() {
            const password = document.getElementById("password").value;
            const toggleIcon = document.querySelector('.toggle-password');
            if (password.trim() === '') {
                toggleIcon.style.display = 'none';
            } else {
                toggleIcon.style.display = 'block';
            }
        });
    </script>
</body>
</html>
