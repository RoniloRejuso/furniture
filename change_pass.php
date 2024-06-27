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
            $mail->setFrom('rejusocute101@gmail.com', 'Our Home');
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
    } else {
        // Email is not registered, show error message
        echo "<script>alert('The recipient email is not registered. Please try again with a registered email address.');</script>";
    }

    $stmt->close();
    $conn->close();
}
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
   
    body {
            background-color:  beige;
            margin: 0;
            padding: 0;
        }
    .form-container {
        max-width: 400px;
        margin: 5px auto;
        padding: 20px;
        background-color: beige;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        border: 5px solid black;
        margin-top: 200px;

    }


    .form-container input[type="email"],
    .form-container input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        font-size: 16px;
    }


    .form-container input[type="submit"] {
        background-color: #ffd698;
        color: white;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .form-container input[type="submit"]:hover {
        background-color:  #ffd698;
    }
    
  .short-email-input {
    width: 200px;
  }

</style>
</head>
<body>
<div class="form-container" style="background-color: lightgray; padding: 20px; width: 600px; height: 200px;">
    <h1 style="color: black;">RESET PASSWORD</h1>
    
    <form method="POST" style="width: 250px; height: 50px; text-align: center;">
    <input type="email" id="email" maxlength="60" name="email" placeholder="Enter email" required class="short-email-input" />
    <input type="submit" name="reset" value="Reset" style="background-color: red; color: white; border: none; padding: 6px 10px; border-radius: 4px; cursor: pointer; font-size: 14px; width: 60px;">
</form>

<script>
    document.getElementById('email').addEventListener('input', function (e) {
        this.value = this.value.replace(/\s/g, '');
    });
</script>


</div>

</body>
</html>






