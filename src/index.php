<?php
require('../vendor/autoload.php');

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$log = new Logger('sendmail');
$log->pushHandler(new StreamHandler('php://stderr', Logger::DEBUG));
$log->debug(json_encode($_POST));

if (isset($_SERVER['HTTP_ORIGIN'])) {
    if ($_SERVER['HTTP_ORIGIN'] == 'https://romankosobrodov.github.io'){
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
                $statusCode = $response->statusCode();
                header('Location: ' . $redirectURL);
                exit();
            } catch (Exception $e) {
                echo 'Caught exception: '. $e->getMessage() ."\n";
            }
        }
        else{
        $log->info("Submit not set");
        exit(); 
        }
    }
    else {
        $log->info("Ignoring request from " . $_SERVER['HTTP_ORIGIN']);
        header('Content-Type: text/html');
        echo "Ignored";
    }
}
?>