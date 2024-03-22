<?php

namespace MPuget\blog\controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Utils\Mail;
use MPuget\blog\Utils\Validations;

class MainController
{
    protected $userRepo;
    protected $twig;

    public function __construct(){
        $this->userRepo = new UserRepository();
        $this->twig = new Twig();
    }

    // une page = une méthode
    public function home()
    {

        // formulaire de contact
        $responseMail = null;
        $dataForFromContact = $_POST;
        if($dataForFromContact) {
            $isValidateData = Validations::validateDataMail($dataForFromContact);
            if ($isValidateData) {
                $mail = new Mail;
                $responseMail = $mail->sendMail($dataForFromContact);
            } else {
                $responseMail = false;
            }
        }

        // // suer connecter
        // if (isset($_SESSION['userId'])){
        //     var_dump('connecter');
        //     $user = $this->userRepo->find($_SESSION['userId']);
        //     var_dump($user);
        // }
        
        $viewData = [
            // 'user' => $user,
            'responseMail' => $responseMail
        ];

        echo $this->twig->getTwig()->render('home.twig', $viewData);
    }

    public function contactForm()
    {
        $mail = new Mail();
        $mail->sendMail();
    }
}
