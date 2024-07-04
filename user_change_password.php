<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

    <style>
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

<body style="background-color: beige;">
    <div class="container p-3 border border-5 rounded-3" style="width: 40%; background-color: white; margin-top:130px">
        <h1 class="display-6 text-center p-2 bg-light">
            Change Password
        </h1>

        <form action="change_password_process.php" method="post" style="background-color: gray; padding: 20px; margin-top: 20px;">

        <div class="row mb-3 justify-content-md-center">
    <label for="inputUsername" class="col-4 col-form-label" style="color: white;">Username</label>
    <div class="col-lg-auto logcontrols">
        <input type="text" maxlength="60" name="username" id="inputUsername" class="form-control" required onkeydown="preventSpace(event)">
        <small id="usernameValidationError" class="form-text text-danger" style="display:none;">Username cannot be purely numerical or purely lowercase letters.</small>
    </div>
</div>

<div class="row mb-3 justify-content-md-center">
    <label for="inputPassword" class="col-4 col-form-label" style="color: white;">New Password</label>
    <div class="col-lg-auto logcontrols">
        <input type="password" name="new_password" id="password" placeholder="Enter Password" class="form-control" maxlength="20" required onkeydown="preventSpace(event)">
        <i class="fas fa-eye toggle-password" onclick="togglePassword('password')" style="color:grey;"></i>
        <small id="passwordStrengthError" class="form-text text-danger" style="display:none;">Password cannot be purely numerical or purely lowercase letters.</small>
    </div>
</div>

    <div class="row mb-3 justify-content-md-center">
        <div class="col-8">
            <button type="submit" class="btn btn-primary" name="change">Change</button>
        </div>
    </div>
</form>

<script>
function preventSpace(event) {
    if (event.key === ' ') {
        event.preventDefault();
    }
}
</script>

<script>
    // Function to check password strength
    function checkPasswordStrength(password) {
        // Minimum password length and required patterns
        var minLength = 6;
        var uppercaseRegex = /[A-Z]/;
        var specialCharRegex = /[!@#$%^&*(),.?":{}|<>]/;

        // Check if password meets criteria
        if (password.length >= minLength && (uppercaseRegex.test(password) || specialCharRegex.test(password))) {
            return true;
        } else {
            return false;
        }
    }

    // Function to toggle password visibility
    function togglePassword(elementId) {
        var passwordInput = document.getElementById(elementId);
        var icon = passwordInput.nextElementSibling;

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = "password";
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    // Event listener to validate password on input
    document.getElementById('password').addEventListener('input', function (e) {
        var password = e.target.value;
        var passwordError = document.getElementById('passwordStrengthError');

        if (!checkPasswordStrength(password)) {
            passwordError.style.display = 'block';
        } else {
            passwordError.style.display = 'none';
        }
    });

    function isValidUsername(username) {
        var textRegex = /^[a-zA-Z]+$/;
        var numberRegex = /^[0-9]+$/;
        var combinedRegex = /^[a-zA-Z]+[0-9a-zA-Z]*$/;

        // Check if username starts with text and contains both text and numbers
        return (username.length <= 60 && !numberRegex.test(username) && combinedRegex.test(username));
    }

    // Event listener to validate username on input
    document.getElementById('inputUsername').addEventListener('input', function () {
            var usernameInput = document.getElementById('inputUsername');
            var usernameError = document.getElementById('usernameValidationError');
            var usernameValue = usernameInput.value;

            if (/^\d+$/.test(usernameValue) || /^[a-z]+$/.test(usernameValue)) {  // Check if the input is purely numerical or purely lowercase letters
                usernameInput.classList.add('red-border');
                usernameError.style.display = 'block';
            } else {
                usernameInput.classList.remove('red-border');
                usernameError.style.display = 'none';
            }
        });

        document.getElementById('password').addEventListener('input', function () {
            var passwordInput = document.getElementById('password');
            var passwordError = document.getElementById('passwordStrengthError');
            var passwordValue = passwordInput.value;

            if (/^\d+$/.test(passwordValue) || /^[a-z]+$/.test(passwordValue)) {  // Check if the input is purely numerical or purely lowercase letters
                passwordInput.classList.add('red-border');
                passwordError.style.display = 'block';
            } else {
                passwordInput.classList.remove('red-border');
                passwordError.style.display = 'none';
            }
        });

        function togglePassword(fieldId) {
            var field = document.getElementById(fieldId);
            if (field.type === "password") {
                field.type = "text";
            } else {
                field.type = "password";
            }
        }


</script>



    </div>
    <script src="sweetalert.min.js"></script>
</body>
</html>
