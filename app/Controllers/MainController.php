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
    }

    // une page = une méthode
    public function home()
    {
        $responseMail = null;
        
        if($_POST) {

            $isValidateData = Validations::validateDataMail($_POST);
            if ($isValidateData) {
                $mail = new Mail;
                $responseMail = $mail->sendMail($_POST);
            } else {
                $responseMail = false;
            }
        }

        $this->twig = new Twig();
       
        $userList = $this->userRepo->find(1);
        
        $viewData = [
            'userList' => $userList,
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
