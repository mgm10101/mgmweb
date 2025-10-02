<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = htmlspecialchars(trim($_POST['name']));
    $email   = htmlspecialchars(trim($_POST['email']));
    $phone   = htmlspecialchars(trim($_POST['phone']));
    $message = htmlspecialchars(trim($_POST['message']));

    if (empty($name) || empty($email) || empty($message)) {
        header("Location: contact.html?status=missing");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../index.html?status=invalid");
        exit();
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = '';
        $mail->Password   = '';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Recipients
        $mail->setFrom('', 'Website Contact Form'); // Use your email as from
        $mail->addAddress(''); // Where to receive messages
        $mail->addReplyTo($email, $name); // So you can reply directly to the sender

        // Create beautiful HTML email template
        $emailTemplate = "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>New Contact Form Submission</title>
            <style>
                body {
                    font-family: 'Arial', sans-serif;
                    line-height: 1.6;
                    color: #333;
                    max-width: 600px;
                    margin: 0 auto;
                    padding: 20px;
                }
                .header {
                    background: linear-gradient(135deg, #355e3b 0%, #67ff94ff 100%);
                    color: white;
                    padding: 30px;
                    text-align: center;
                    border-radius: 10px 10px 0 0;
                }
                .content {
                    background: #f9f9f9;
                    padding: 30px;
                    border-radius: 0 0 10px 10px;
                    border: 1px solid #e0e0e0;
                    border-top: none;
                }
                .field {
                    margin-bottom: 20px;
                    padding: 15px;
                    background: white;
                    border-radius: 8px;
                    border-left: 4px solid #355e3b;
                }
                .field-label {
                    font-weight: bold;
                    color: #355e3b;
                    display: block;
                    margin-bottom: 5px;
                    font-size: 14px;
                    text-transform: uppercase;
                }
                .field-value {
                    color: #333;
                    font-size: 16px;
                }
                .message-box {
                    background: white;
                    padding: 20px;
                    border-radius: 8px;
                    border: 1px solid #e0e0e0;
                    margin-top: 10px;
                }
                .footer {
                    text-align: center;
                    margin-top: 30px;
                    padding: 20px;
                    color: #666;
                    font-size: 12px;
                    border-top: 1px solid #e0e0e0;
                }
            </style>
        </head>
        <body>
            <div class='header'>
                <h1>📧 New Contact Form Submission</h1>
                <p>You have received a new message from your website</p>
            </div>
            
            <div class='content'>
                <div class='field'>
                    <span class='field-label'>From</span>
                    <span class='field-value'>{$name}</span>
                </div>
                
                <div class='field'>
                    <span class='field-label'>Email Address</span>
                    <span class='field-value'>{$email}</span>
                </div>
                
                <div class='field'>
                    <span class='field-label'>Phone Number</span>
                    <span class='field-value'>" . ($phone ? $phone : 'Not provided') . "</span>
                </div>
                
                <div style='margin-top: 25px;'>
                    <span class='field-label'>Message</span>
                    <div class='message-box'>
                        " . nl2br($message) . "
                    </div>
                </div>
            </div>
            
            <div class='footer'>
                <p>This email was sent from your website contact form on " . date('F j, Y \a\t g:i A') . "</p>
                <p>You can reply directly to this email to respond to {$name}.</p>
            </div>
        </body>
        </html>";

        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission from {$name}";
        $mail->Body    = $emailTemplate;
        
        // Add plain text version for email clients that don't support HTML
        $mail->AltBody = "
        New Contact Form Submission
        
        From: {$name}
        Email: {$email}
        Phone: " . ($phone ? $phone : 'Not provided') . "
        
        Message:
        {$message}
        
        Sent from your website contact form on " . date('F j, Y \a\t g:i A');

        $mail->send();

        header("Location: ../index.html?status=success");
        exit();

    } catch (Exception $e) {
        header("Location: ../index.html?status=error");
        exit();
    }
} else {
    header("Location: ../index.html?status=invalid");
    exit();
}
