<?php
$email = isset($_GET['email']) ? $_GET['email'] : '';
$verification_code = isset($_GET['code']) ? $_GET['code'] : '';

// Check if the form is submitted for email verification
if (isset($_POST['verify_email'])) {
    $entered_code = $_POST['verification_code'];

    // Check if the entered code matches the verification code
    if ($entered_code === $verification_code) {
        // Verification successful, redirect to the change password page
        header("Location: change_password.php");
        exit(); // Ensure no further code is executed after redirection
    }  else {
        // Display an error message using SweetAlert
        echo '<script>
                // Include SweetAlert library
                const script = document.createElement("script");
                script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@10";
                document.head.appendChild(script);

                // Trigger SweetAlert for verification failure
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Verification Failed",
                        text: "Verification code is incorrect. Please try again."
                    });
                });
              </script>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Verification</title>

    <link rel="shortcut icon" href="assets/img/badbunny.jpg">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<style>
    /* Form container style */
    .verification-form {
        max-width: 300px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Input field style */
    .verification-form input[type="text"],
    .verification-form input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 16px;
        box-sizing: border-box;
    }

    /* Submit button style */
    .verification-form input[type="submit"] {
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .verification-form input[type="submit"]:hover {
        background-color: #0056b3;
    }
    #timerDisplay {
            color: white;
        }
</style>

<body>
    <div class="image-container">
        <img src="assets/img/badbunny-removebg-preview.png" alt="Pic" class="text-img">
    </div>
    <div class="row">
        <div class="title-header">
            <h5 style="color: #ffffff">SALES AND INVENTORY MANAGEMENT SYSTEM</h5>
        </div>
    </div>
    <div class="container">
        <div class="row d-flex">
            <div class="col-12 align-self-center">
                <div class="card">
                    <div class="card-body auth-header-box">
                        <div class="text-center">
                            <h3 class="mt-3 mb-5" style="font-family: Arial, Helvetica, sans-serif; color: #ffffff;">Verification</h3>
                            <h5 class="text-muted" style="line-height: 1;">Enter the 6-digit verification code <br> sent to your email account</h5>
                        </div>
                    </div>
                    <div class="card-body">
                    

                    <form method="POST" class="verification-form" id="verificationForm">
    <input type="hidden" name="email" value="<?php echo $email; ?>" required>
    <input type="text" name="verification_code" id="verificationCodeInput" placeholder="Enter verification code" required maxlength="6" pattern="[0-9]{6}" title="Please enter a 6-digit numeric verification code" oninput="this.value = this.value.replace(/\D/g, '')">
    <input type="submit" name="verify_email" value="Verify Email">
</form>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const verificationCodeInput = document.getElementById('verificationCodeInput');

        verificationCodeInput.addEventListener('input', function() {
            const maxLength = 6; // Define the maximum length
            if (this.value.length > maxLength) {
                this.value = this.value.slice(0, maxLength); // Truncate the value
            }
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<
<div id="timerDisplay"></div>

<!-- Resend button -->
<button id="resendButton" onclick="resendEmail()" disabled>Resend</button>

<script>
    let timer;
    let timeLeft = 60;

    function startTimer() {
        timer = setInterval(() => {
            timeLeft--;
            if (timeLeft === 0) {
                clearInterval(timer);
                document.getElementById('resendButton').disabled = false;
                document.getElementById('timerDisplay').innerText = 'Timer expired';
            } else {
                document.getElementById('timerDisplay').innerText = `Time left: ${timeLeft} seconds`;
            }
        }, 1000);
    }

    function resendEmail() {
        document.getElementById('resendButton').disabled = true;
        timeLeft = 60;
        startTimer();

        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4) {
                if (this.status === 200) {
                    Swal.fire({
                        title: 'Send another!',
                        text: this.responseText,
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'change_pass.php';
                    });
                } else {
                    Swal.fire({
                        title: 'Error',
                        text: 'Email could not be resent!',
                        icon: 'error',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                }
            }
        };
        xhr.open('POST', 'resend.php', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send('resend=true');
    }

    window.onload = function() {
        startTimer();
    };
</script>

                    </div>
                    <div class="card-body bg-light-alt text-center">
                        <h5 class="text-muted d-none d-sm-inline-block">Bad Bunny SIMS © 2023</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/script.js"></script>
    <script src="sweetalert.min.js"></script>
</body>

</html>