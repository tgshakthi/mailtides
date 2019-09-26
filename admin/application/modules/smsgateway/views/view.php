<?php

// Update the path below to your autoload.php,
// see https://getcomposer.org/doc/01-basic-usage.md
require_once("application/third_party/Twilio/autoload.php");
use Twilio\Rest\Client;

// Find your Account Sid and Auth Token at twilio.com/console
// DANGER! This is insecure. See http://twil.io/secure
$sid    = "AC839320f02176c877d19a2816218a9674";
$token  = "943086168eb029d1f2e5af5455284fde";
$twilio = new Client($sid, $token);

$message = $twilio->messages
                  ->create("+17139339132", // to
                           array(
                               "body" => "Hello Desss !!!",
                               "from" => "+12818843247"
                           )
                  );

print($message->sid);