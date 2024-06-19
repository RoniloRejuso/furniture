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
    .form-group {
        position: relative;
    }
    .toggle-password {
        position: absolute;
        top: 75%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        display: none; /* Initially hide the icon */
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
                        </div>

                        <div class="form-group">
                            <label for="password">Password:</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" maxlength="10" required>
                            <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('password')"></i>
                        </div>
                        <button type="submit" class="btn btn-primary" id="login_btn" name="login_btn">Login</button>
                        <div class="or-divider">
                            <span class="divider-line"></span> OR <span class="divider-line"></span>
                        </div>
                        <button type="button" class="btn btn-custom-color" data-toggle="modal" data-target="#signupModal">Create Account</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

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
                            <input type="text" class="form-control" id="firstname" pattern="[A-Z a-z ]+" name="firstname" placeholder="Enter first name" maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last name:</label>
                            <input type="text" class="form-control" id="lastname" pattern="[A-Z a-z ]+" name="lastname" placeholder="Enter last name" maxlength="50">
                        </div>
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
                            <label for="signupEmail">Email:</label>
                            <input type="email" class="form-control" id="signupEmail" name="email" placeholder="Enter your email" maxlength="50">
                        </div>

                        <div class="form-group">
                            <label for="signupPassword">Password:</label>
                            <input type="password" class="form-control" id="npassword" name="password" placeholder="Enter your password" maxlength="10" required>
                            <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('npassword')"></i>
                        </div>

                        <div class="form-group">
                            <label for="signupCPassword">Confirm Password:</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm your password" maxlength="10" required>
                            <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('cpassword')"></i>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" name="acceptTerms">
                            <label class="form-check-label" for="acceptTerms">I agree and consent to the collection, use or otherwise processing of my personal data by Casamia Furniture Center, Inc. (“Our Home”) and its service group. I agree to be bound by the Website’s Terms of Service and Privacy Notice.</label>
                        </div>

                        <button type="submit" class="btn btn-create-account mt-3" name="register_btn" id="register_btn">Create</button>
                    </form>

                    <script>
                        // Password Validation
                        function validatePassword(inputElement) {
                            const passwordValue = inputElement.value;
                            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*_)[A-Za-z\d_]{8,}$/;

                            if (!passwordRegex.test(passwordValue)) {
                                inputElement.classList.add('error');
                            } else {
                                inputElement.classList.remove('error');
                            }
                        }

                        document.getElementById('npassword').addEventListener('input', function () {
                            validatePassword(this);
                        });

                        document.getElementById('cpassword').addEventListener('input', function () {
                            validatePasswords();
                        });

                        function validatePasswords() {
                            const password = document.getElementById('npassword').value;
                            const confirmPassword = document.getElementById('cpassword').value;

                            if (password !== confirmPassword) {
                                document.getElementById('cpassword').classList.add('error');
                            } else {
                                document.getElementById('cpassword').classList.remove('error');
                            }
                        }

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
            document.getElementById("mySidenav").style.width = "360px";
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
