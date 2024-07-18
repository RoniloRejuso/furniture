

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Verification</title>

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>

    .verification-form {
        max-width: 300px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
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
        .image-container {
            text-align: center;
            margin-right: 100px; 
            margin-left: 100px;  
            margin-top: 50px;    
            margin-bottom: 50px; 
        }
        .text-img {
            display: block;
            margin: auto;   
            max-width: 100%; 
            height: auto;
        }
</style>

<body>


<?php
include 'dbcon.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'mail/Exception.php';
require 'mail/PHPMailer.php';
require 'mail/SMTP.php';

$email = isset($_GET['email']) ? $_GET['email'] : '';
$verification_code = isset($_GET['code']) ? $_GET['code'] : '';

if (isset($_POST['verify_email'])) {
    $entered_code = $_POST['verification_code'];
    if ($entered_code === $verification_code) {
        header("Location: change_password.php");
        exit();
    } else {
        echo '<script>
                // Include SweetAlert library
                const script = document.createElement("script");
                script.src = "https://cdn.jsdelivr.net/npm/sweetalert2@11";
                document.head.appendChild(script);

                // Trigger SweetAlert for verification failure
                document.addEventListener("DOMContentLoaded", function() {
                    Swal.fire({
                        icon: "error",
                        title: "Verification Failed",
                        text: "Verification code is incorrect. Please try again.",
                        confirmButtonText: "OK"
                    });
                });
              </script>';
    }
}

if (isset($_POST['resend_verification'])) {
    $email = $_POST['email'];

    // Generate new verification code
    $new_verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

    // Send the new verification code via email
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

        $mail->Subject = 'Email verification';
        $mail->Body = '<p>Your new verification code is: <b style="font-size: 30px;">' . $new_verification_code . '</b></p>';

        $mail->send();

        // Update the verification code in the URL
        header("Location: change_code.php?email=" . $email . "&code=" . $new_verification_code);
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
    <div class="image-container" margin-right: 100px;>
        <img src="assets/img/FurniView.png" alt="Pic" class="text-img">
    </div>
    <div class="row">

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
    <input style="background-color: #964B33;" type="submit" name="verify_email" value="Verify Email">
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

                    </div>
                    <div class="card-body bg-light-alt text-center" >
                        <h5  class="text-muted d-none d-sm-inline-block" style="color: black;">FurniView Furniture Shop</h5>
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
