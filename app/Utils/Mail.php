<?php

namespace MPuget\blog\Utils;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Mail {

    // TODO pour pouvroi utiliser la fonction de amil il faut, lancer le conteneur docker de maildev (docker compose up -d on peut vérifier qu'il est up avec docker compose ps)
    public function sendMail (Array $data) : bool
    {
       var_dump($data);
        $transport = (new \Swift_SmtpTransport('172.18.0.2', 1025));

        // Create the Mailer using your created Transport
        $mailer = new \Swift_Mailer($transport);

        // Create a message
        $message = (new \Swift_Message('Formulaire de contact'))
        ->setFrom(['contact@UnSitePourVous.net' => 'UnSitePourVous'])
        ->setTo([$data['email']=> $data['name']])
        ->setBody($data['message'])
        ;

        // Send the message
        $result = $mailer->send($message);
        
        return $result;
    }


}
