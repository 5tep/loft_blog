<?php
   
require_once 'vendor/autoload.php';

// Create the Transport
$transport = (new Swift_SmtpTransport('smtp.mail.ru', 465, 'ssl'))
->setUsername('testloftprj@mail.ru')
->setPassword('pENk5Rt7@:RYRR')
;
// Create the Mailer using your created Transport
$mailer = new Swift_Mailer($transport);

// Create a message
$message = (new Swift_Message('Регистрация'))
->setFrom(['testloftprj@mail.ru' => 'Admin'])
->setTo(['step@i.ru', 'step@i.ru' => 'Cntgfy'])
->setBody('$message_text')
;

// Send the message
return $mailer->send($message);
?>
