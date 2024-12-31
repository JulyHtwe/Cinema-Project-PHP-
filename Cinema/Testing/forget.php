<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

// Get form data
$userName = $_POST['name'];
$userEmail = $_POST['email'];

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                         // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                     // Enable SMTP authentication
    $mail->Username   = 'your-email@gmail.com';                   // SMTP username
    $mail->Password   = 'your-gmail-password';                    // SMTP password (Use app password if 2FA enabled)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;           // Enable TLS encryption
    $mail->Port       = 587;                                      // TCP port to connect to

    //Recipients
    $mail->setFrom('your-email@gmail.com', 'Your Name');          // From address and name
    $mail->addAddress($userEmail, $userName);                      // Add recipient (user's email and name)

    // Content
    $mail->isHTML(true);                                          // Set email format to HTML
    $mail->Subject = 'Welcome to Our Service, ' . $userName;
    $mail->Body    = "
        <html>
        <body>
            <h1>Hello, $userName!</h1>
            <p>Welcome to our service. We're excited to have you with us.</p>
        </body>
        </html>
    ";
    $mail->AltBody = 'Welcome to our service. Your account has been successfully created.';

    // Send the email
    if ($mail->send()) {
        echo 'Message has been sent';
    } else {
        echo 'Message could not be sent.';
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<form action="#" method="POST">
    Name: <input type="text" name="name" required><br>
    Email: <input type="email" name="email" required><br>
    <input type="submit" value="Register">
</form>

</body>
</html>