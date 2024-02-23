<?php

namespace MPuget\blog\Utils;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

// require 'path/to/PHPMailer/src/Exception.php';
// require 'path/to/PHPMailer/src/PHPMailer.php';
// require 'path/to/PHPMailer/src/SMTP.php';

class Mail {

    // TODO pour pouvroi utiliser la fonction de amil il faut, lancer le conteneur docker de maildev (docker composer up -d on peut vérifier qu'il est up avec docker compose ps)
    //! Pour le moment ça ne fonctinne pas !
    public function sendMail() {
        var_dump('Mail::sendMail()');

          //Create an instance; passing `true` enables exceptions
          $mail = new PHPMailer(true);

          try {
              //Server settings
              $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
              //$mail->isSMTP();                                            //Send using SMTP
              $mail->Host       = 'localhost';                     //Set the SMTP server to send through
             // $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
              /* $mail->Username   = 'user@example.com';                     //SMTP username
              $mail->Password   = 'secret'; */                               //SMTP password
              //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
              $mail->Port       = 32768;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

              //Recipients
              $mail->setFrom('from@example.com', 'Mailer');
               $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
              /*$mail->addAddress('ellen@example.com');               //Name is optional
              $mail->addReplyTo('info@example.com', 'Information');
              $mail->addCC('cc@example.com');
              $mail->addBCC('bcc@example.com'); */

              // //Attachments
              // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
              // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

              
                //Content
                $mail->isHTML(true);                                  //Set email format to HTML
                $mail->Subject = 'Here is the subject';
                $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

              $mail->send();                             
              $mail->Subject = 'Here is the subject';
                 
              echo 'Message has been sent';          
                
          } catch (Exception $e) {
              echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}<br>";
          }
    }
}
