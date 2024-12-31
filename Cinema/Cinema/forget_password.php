<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';
require_once 'Model/db.php';

$email=$_POST['email'];
// Assume we get user info from database
$sql = "SELECT * FROM user WHERE email = '$email'"; // Example: Select user with id 1
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Fetch data
    while($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $password=$row['password'];
    }
} else {
    echo "No data found";
}
$conn->close();

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
            <h1>Hello, $username!</h1>
            <p>Welcome to our service. We're excited to have you with us.</p>
            <p>Your account has been successfully created. You can start using our platform today.</p>
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
