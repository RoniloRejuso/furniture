<!DOCTYPE html>
<html lang="en">
<?php
include 'user_header.php';
?>
<head>
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
            display: none;
        }
        .validation-message {
            color: red;
            font-size: 0.875em;
            display: none;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
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
                    <form id="loginForm" method="POST" action="user_dex.php">
                        <div class="form-group">
                            <label for="email">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" maxlength="50" required>
                            <div class="validation-message">Please enter a valid email address.</div>
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
                            <input type="text" class="form-control" id="firstname" pattern="[A-Z a-z ]+" name="firstname" placeholder="Enter first name" maxlength="20" required>
                            <div class="validation-message">Please enter a valid first name.</div>
                        </div>

                        <div class="form-group">
                            <label for="lastname">Last name:</label>
                            <input type="text" class="form-control" id="lastname" pattern="[A-Z a-z ]+" name="lastname" placeholder="Enter last name" maxlength="20" required>
                            <div class="validation-message">Please enter a valid last name.</div>
                        </div>

                        <div class="form-group">
                            <label for="signupEmail">Email:</label>
                            <input type="email" class="form-control" id="signupEmail" name="email" placeholder="Enter your email" maxlength="50" required>
                            <div class="validation-message">Please enter a valid email address.</div>
                        </div>

                        <div class="form-group">
                            <label for="signupPassword">Password:</label>
                            <input type="password" class="form-control" id="npassword" name="password" placeholder="Enter your password" maxlength="10" required>
                            <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('npassword')"></i>
                            <div class="validation-message">Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a digit, and a special character.</div>
                        </div>

                        <div class="form-group">
                            <label for="signupCPassword">Confirm Password:</label>
                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm your password" maxlength="10" required>
                            <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('cpassword')"></i>
                            <div class="validation-message">Passwords do not match.</div>
                        </div>

                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" name="acceptTerms">
                            <label class="form-check-label" for="acceptTerms">I agree and consent to the collection, use or otherwise processing of my personal data by Casamia Furniture Center, Inc. (“Our Home”) and its service group. I agree to be bound by the Website’s Terms of Service and Privacy Notice.</label>
                            <div class="validation-message">You must accept the terms and conditions.</div>
                        </div>

                        <button type="submit" class="btn btn-create-account mt-3" name="register_btn" id="register_btn">Create</button>
                    </form>
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
        function validateInput(inputElement) {
            // Remove leading spaces
            inputElement.value = inputElement.value.replace(/^\s+/g, '');

            // Allow only single spaces between words and capitalize each word
            let inputValue = inputElement.value.trim();
            let parts = inputValue.split(/\s+/);

            for (let i = 0; i < parts.length; i++) {
                parts[i] = parts[i].charAt(0).toUpperCase() + parts[i].slice(1).toLowerCase();
            }

            inputElement.value = parts.join(' ');
        }

        document.getElementById("firstname").addEventListener("input", function () {
            validateInput(this);
        });

        document.getElementById("lastname").addEventListener("input", function () {
            validateInput(this);
        });

        function validatePassword(inputElement) {
            const passwordValue = inputElement.value;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

            const validationMessage = inputElement.nextElementSibling;
            if (passwordRegex.test(passwordValue)) {
                inputElement.classList.remove("invalid");
                inputElement.classList.add("valid");
                validationMessage.style.display = "none";
            } else {
                inputElement.classList.remove("valid");
                inputElement.classList.add("invalid");
                validationMessage.style.display = "block";
            }
        }

        document.getElementById("npassword").addEventListener("input", function () {
            validatePassword(this);
        });

        document.getElementById("cpassword").addEventListener("input", function () {
            const npassword = document.getElementById("npassword").value;
            const cpassword = this.value;

            const validationMessage = this.nextElementSibling;
            if (npassword === cpassword) {
                this.classList.remove("invalid");
                this.classList.add("valid");
                validationMessage.style.display = "none";
            } else {
                this.classList.remove("valid");
                this.classList.add("invalid");
                validationMessage.style.display = "block";
            }
        });

        function togglePassword(elementId) {
            const passwordInput = document.getElementById(elementId);
            const passwordToggle = passwordInput.nextElementSibling;

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                passwordToggle.classList.remove("fa-eye");
                passwordToggle.classList.add("fa-eye-slash");
            } else {
                passwordInput.type = "password";
                passwordToggle.classList.remove("fa-eye-slash");
                passwordToggle.classList.add("fa-eye");
            }
        }

        function validateForm() {
            const acceptTerms = document.getElementById("acceptTerms").checked;
            if (!acceptTerms) {
                const validationMessage = document.querySelector("#acceptTerms + .validation-message");
                validationMessage.style.display = "block";
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
