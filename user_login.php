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
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
        display: none;
    }
    .invalid-feedback {
        display: block;
        color: red;
        font-size: 0.875em;
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
                    <form id="signupForm" method="POST" action="user_dex.php" class="validated-form" onsubmit="return validateForm()">
                        <div class="form-group">
                            <label for="firstname" style="margin-bottom:20px;">First name:</label>
                            <input type="text" class="form-control name" id="firstname" name="firstname" placeholder="Enter first name" maxlength="100">
                            <div class="invalid-feedback"></div>
                        </div><br>
                        <div class="form-group">
                            <label for="lastname" style="margin-bottom:20px;">Last name:</label>
                            <input type="text" class="form-control name" id="lastname" name="lastname" placeholder="Enter last name" maxlength="100">
                            <div class="invalid-feedback"></div>
                        </div><br>
                        <div class="form-group">
                            <label for="signupEmail">Email:</label>
                            <input type="email" class="form-control email" id="signupEmail" name="email" placeholder="Enter your email" maxlength="100">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="signupPassword">Password:</label>
                            <input type="password" class="form-control password" id="npassword" name="password" placeholder="Enter your password" maxlength="20" required>
                            <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('npassword')"></i>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="signupCPassword">Confirm Password:</label>
                            <input type="password" class="form-control password" id="cpassword" name="cpassword" placeholder="Confirm your password" maxlength="20" required>
                            <i class="fas fa-eye toggle-password" style="color:grey;" onclick="togglePassword('cpassword')"></i>
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="acceptTerms" name="acceptTerms" required>
                            <label class="form-check-label" for="acceptTerms">I agree and consent to the collection, use or otherwise processing of my personal data by Casamia Furniture Center, Inc. (“Our Home”) and its service group. I agree to be bound by the Website’s Terms of Service and Privacy Notice.</label>
                            <div class="invalid-feedback"></div>
                        </div>
                        <button type="submit" class="btn btn-create-account mt-3" name="register_btn" id="register_btn">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/plugin.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="https:cdnjs.cloudflare.com/ajax/libs/fancybox/2.1.5/jquery.fancybox.min.js"></script>
    <script src="https://unpkg.com/gijgo@1.9.13/js/gijgo.min.js" type="text/javascript"></script>

    <script>
        function togglePassword(id) {
            const passwordField = document.getElementById(id);
            const eyeIcon = passwordField.nextElementSibling;
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordField.type = ('password');
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

        document.addEventListener('DOMContentLoaded', function () {
            const forms = document.querySelectorAll('.validated-form');

            forms.forEach(form => {
                const contactNumbers = form.querySelectorAll('.contact-number');
                const names = form.querySelectorAll('.name');
                const emails = form.querySelectorAll('.email');
                const passwords = form.querySelectorAll('.password');
                const fileUploads = form.querySelectorAll('.file-upload');
                const selectFields = form.querySelectorAll('.select-field');
                const checkboxes = form.querySelectorAll('.form-check-input');
                const submitButton = form.querySelector('button[type="submit"]');

                contactNumbers.forEach(input => {
                    input.addEventListener('input', handleContactNumberInput);
                    input.addEventListener('blur', handleBlur);
                });

                names.forEach(input => {
                    input.addEventListener('input', handleNameInput);
                    input.addEventListener('blur', handleBlur);
                });

                emails.forEach(input => {
                    input.addEventListener('input', handleEmailInput);
                    input.addEventListener('blur', handleBlur);
                    input.addEventListener('keydown', preventSpace);
                });

                passwords.forEach(input => {
                    input.addEventListener('input', handlePasswordInput);
                    input.addEventListener('blur', handleBlur);
                    input.addEventListener('keydown', preventSpace);
                });

                fileUploads.forEach(input => {
                    input.addEventListener('input', handleFileUpload);
                });

                selectFields.forEach(select => {
                    select.addEventListener('input', handleSelectInput);
                    select.addEventListener('blur', handleBlur);
                });

                checkboxes.forEach(checkbox => {
                    checkbox.addEventListener('change', handleCheckboxChange);
                });

                form.addEventListener('submit', (event) => {
                    event.preventDefault();
                    if (validateForm()) {
                        form.submit();
                    }
                });
            });

            function handleCheckboxChange(event) {
                const checkbox = event.target;
                const feedback = checkbox.nextElementSibling.nextElementSibling;
                feedback.textContent = checkbox.checked ? '' : 'You must agree to the terms';
                checkbox.classList.toggle('is-invalid', !checkbox.checked);
            }

            function handleContactNumberInput(event) {
                const input = event.target;
                const value = input.value.trim();
                const feedback = input.nextElementSibling;

                const phonePattern = /^(09|\+639)\d{9}$/;
                if (value === '') {
                    feedback.textContent = 'Contact number is required';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else if (!phonePattern.test(value)) {
                    feedback.textContent = 'Invalid contact number format';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    feedback.textContent = '';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            }

            function handleNameInput(event) {
                const input = event.target;
                const value = input.value.trim();
                const feedback = input.nextElementSibling;

                if (value === '') {
                    feedback.textContent = 'This field is required';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    feedback.textContent = '';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            }

            function handleEmailInput(event) {
                const input = event.target;
                const value = input.value.trim();
                const feedback = input.nextElementSibling;

                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value === '') {
                    feedback.textContent = 'Email is required';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else if (!emailPattern.test(value)) {
                    feedback.textContent = 'Invalid email format';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    feedback.textContent = '';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            }

            function handlePasswordInput(event) {
                const input = event.target;
                const value = input.value.trim();
                const feedback = input.nextElementSibling;

                const passwordPattern = /^(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/;
                if (value === '') {
                    feedback.textContent = 'Password is required';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else if (!passwordPattern.test(value)) {
                    feedback.textContent = 'Password must be at least 8 characters long, include at least one uppercase letter and one number';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    feedback.textContent = '';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            }

            function handleFileUpload(event) {
                const input = event.target;
                const file = input.files[0];
                const feedback = input.nextElementSibling;

                if (!file) {
                    feedback.textContent = 'Please upload a file';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else if (file.size > 5 * 1024 * 1024) {
                    feedback.textContent = 'File size must be less than 5MB';
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                } else {
                    feedback.textContent = '';
                    input.classList.remove('is-invalid');
                    input.classList.add('is-valid');
                }
            }

            function handleSelectInput(event) {
                const select = event.target;
                const feedback = select.nextElementSibling;

                if (select.value === '') {
                    feedback.textContent = 'This field is required';
                    select.classList.add('is-invalid');
                    select.classList.remove('is-valid');
                } else {
                    feedback.textContent = '';
                    select.classList.remove('is-invalid');
                    select.classList.add('is-valid');
                }
            }

            function handleBlur(event) {
                const input = event.target;
                if (input.value.trim() === '') {
                    input.classList.add('is-invalid');
                    input.classList.remove('is-valid');
                }
            }

            function preventSpace(event) {
                if (event.key === ' ') {
                    event.preventDefault();
                }
            }

            function validateForm() {
                const forms = document.querySelectorAll('.validated-form');
                let isValid = true;

                forms.forEach(form => {
                    const inputs = form.querySelectorAll('input, select');
                    inputs.forEach(input => {
                        if (!input.checkValidity()) {
                            input.classList.add('is-invalid');
                            input.classList.remove('is-valid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                            input.classList.add('is-valid');
                        }
                    });
                });

                return isValid;
            }
        });
    </script>
</body>
</html>
