<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Check for form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  // Get the form data
  $name = $_POST['name'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  // Validate the form data
  if (empty($name) || empty($email) || empty($message)) {
    // Display an error message if any fields are empty
    echo 'Please fill out all fields.';
  } else {
    // Send the email
    $mail = new PHPMailer(true);

    try {
      //Server settings
      $mail->SMTPDebug = 0;                                       // Enable verbose debug output
      $mail->isSMTP();                                            // Send using SMTP
      $mail->Host       = 'smtp.gmail.com';                       // Set the SMTP server to send through
      $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
      $mail->Username   = 'your-email@gmail.com';                 // SMTP username
      $mail->Password   = 'your-email-password';                   // SMTP password
      $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
      $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

      //Recipients
      $mail->setFrom($email, $name);
      $mail->addAddress('recipient-email@example.com');           // Add a recipient email address

      // Content
      $mail->isHTML(false);                                        // Set email format to plain text
      $mail->Subject = 'New Contact Form Submission';
      $mail->Body    = "Name: $name\nEmail: $email\nMessage: $message";

      $mail->send();
      echo 'Thank you for your message! We will get back to you soon.';
    } catch (Exception $e) {
      echo "There was a problem sending your message. Please try again later. Error: {$mail->ErrorInfo}";
    }
  }
}
?>
