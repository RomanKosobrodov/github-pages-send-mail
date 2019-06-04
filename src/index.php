<?php
require('../vendor/autoload.php');
if(isset($_POST['submit'])){
    $sender = $_POST['sender'];
    $emailAddress = $_POST['email'];
    $message = $_POST['message'];
    $redirectURL = $_POST['redirect'];

    $email = new SendGrid\Mail\Mail(); 
    $email->setFrom($emailAddress, $sender);
    $email->setSubject("Contact Form sent from GitHub Pages");
    $email->addTo(getenv('RECIPIENT_EMAIL'), getenv('RECIPIENT_NAME'));
    $email->addContent("text/plain", $message);

    $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
    try {
        $response = $sendgrid->send($email);
        header('Location: ' . $redirectURL);
        #print $response->statusCode() . "\n";
        #print_r($response->headers());
        #print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }
}
?>