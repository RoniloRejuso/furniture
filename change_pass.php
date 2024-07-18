<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FurniView</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap">
    <link rel="stylesheet" href="css/changepass.css">
</head>
<body>

<?php
include 'dbcon.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

if (isset($_POST["reset"])) {
    $email = $_POST["email"];

    // Check if the email is registered in the database
    $query = "SELECT * FROM admin WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Email is registered, proceed with sending the email
        $mail = new PHPMailer(true);

        try {
            $mail->SMTPDebug = 0;
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'rejusocute101@gmail.com';
            $mail->Password = 'ecae dvfi mhpi aozw';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('rejusocute101@gmail.com', 'FurniView');
            $mail->addAddress($email);
            $mail->isHTML(true);

            $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

            $mail->Subject = 'Email verification';
            $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

            $mail->send();

            // Redirect to email_verify.php passing email and verification code
            header("Location: change_code.php?email=" . $email . "&code=" . $verification_code);
            exit();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    } else {
        // Email is not registered, show error message using SweetAlert
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'The recipient email is not registered. Please try again with a registered email address.'
                });
              </script>";
    }

    $stmt->close();
    $conn->close();
}
?> 

<div class="form-container">
    <img src="images/logo.png" alt="Logo" class="logo">    
    <h3>RESET PASSWORD</h3>
    <form method="POST">
        <input type="email" id="email" maxlength="60" name="email" placeholder="Enter email" required class="short-email-input" />
        <small id="emailValidationError" class="form-text text-danger">Invalid email format or domain does not exist.</small>
        <br>
        <input type="submit" name="reset" value="Reset">
    </form>

    <script>
        function validateEmail() {
            const emailInput = document.getElementById('email');
            const emailError = document.getElementById('emailValidationError');
            const emailValue = emailInput.value;

            if (/\s/.test(emailValue)) {
                emailError.style.display = 'block';
                emailError.textContent = 'Email should not contain spaces or whitespace.';
                return false;
            } else {
                emailError.style.display = 'none';
                return true;
            }
        }

        document.getElementById('email').addEventListener('input', function(event) {
            const emailInput = event.target;
            emailInput.value = emailInput.value.replace(/\s/g, '');
        });
    </script>

    <script>
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
    </script>

</div>

</body>
</html>
