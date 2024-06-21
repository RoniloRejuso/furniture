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
        $mail->setFrom('rejusocute101@gmail.com', 'BADBUNNY');
        $mail->addAddress($email);
        $mail->isHTML(true);

        $verification_code = substr(number_format(time() * rand(), 0, '', ''), 0, 6);

        $mail->Subject = 'Email verification';
        $mail->Body = '<p>Your verification code is: <b style="font-size: 30px;">' . $verification_code . '</b></p>';

        $mail->send();

        // Assuming you want to redirect to email_verify.php passing email and verification code
        header("Location: change_code.php?email=" . $email . "&code=" . $verification_code);
        exit();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
    /* Form container style */
    body {
            background-color: gray;
            margin: 0;
            padding: 0;
        }
    .form-container {
        max-width: 400px;
        margin: 5px auto;
        padding: 20px;
        background-color: #f9f9f9;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 5px solid black;
    }

    /* Input field style */
    .form-container input[type="email"],
    .form-container input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 16px;
    }

    /* Submit button style */
    .form-container input[type="submit"] {
        background-color: #007bff;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-container input[type="submit"]:hover {
        background-color: #0056b3;
    }
</style>
</head>
<body>
<div class="form-container" style="background-color: gray; padding: 20px;">
    <h1 style="color: white;">RESET PASSWORD</h1>
    <form method="POST">
        <input type="email" maxlength="60" name="email" placeholder="Enter email" required />
        <input type="submit" name="reset" value="Reset" style="background-color: red; color: white; border: none; padding: 8px 12px; border-radius: 4px; cursor: pointer;">
    </form>
</div>

</body>
</html>






