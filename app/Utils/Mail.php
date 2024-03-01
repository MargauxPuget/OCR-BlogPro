<?php

namespace MPuget\blog\Utils;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

class Mail {

    
    public function sendMail (Array $data) : bool
    {

        $result = $this->validateInformation($data);

        if (!$result) {
            return false;
        }

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

    private function validateInformation(Array $data) {

        if (isset($data)){
            if (
                !isset($data['name'])
                || !isset($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)
                || !isset($data['message'])
            ) {
                var_dump(false);
                return false;
            }
            var_dump(true);
            return true;
        }
    }
}
