<?php
require('../vendor/autoload.php');
$email = new SendGrid\Mail\Mail(); 
$email->setFrom("test@example.com", "Example User");
$email->setSubject("GitHub Pages Contact");
$email->addTo(getenv('RECIPIENT_EMAIL'), getenv('RECIPIENT_NAME'));
$email->addContent("text/plain", "contact form content goes here");

$sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
try {
    $response = $sendgrid->send($email);
    print $response->statusCode() . "\n";
    print_r($response->headers());
    print $response->body() . "\n";
} catch (Exception $e) {
    echo 'Caught exception: '. $e->getMessage() ."\n";
}