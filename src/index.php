<?php
require('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('name');
$log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));

if(isset($_POST['submit'])){
    $sender = $_POST['sender'];
    $emailAddress = $_POST['email'];
    $message = $_POST['message'];
    $redirectURL = $_POST['redirect'];

    $log->debug($_POST);

    $email = new SendGrid\Mail\Mail(); 
    $email->setFrom($emailAddress, $sender);
    $email->setSubject("Contact Form sent from GitHub Pages");
    $email->addTo(getenv('RECIPIENT_EMAIL'), getenv('RECIPIENT_NAME'));
    $email->addContent("text/plain", $message);

    $sendgrid = new SendGrid(getenv('SENDGRID_API_KEY'));
    try {
        $response = $sendgrid->send($email);
        $statusCode = $response->statusCode();
        header('Location: ' . $redirectURL);
        exit();
        #print $response->statusCode() . "\n";
        #print_r($response->headers());
        #print $response->body() . "\n";
    } catch (Exception $e) {
        echo 'Caught exception: '. $e->getMessage() ."\n";
    }
}
else{
   $log->debug("Submit not set");
   exit(); 
}
?>