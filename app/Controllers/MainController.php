<?php

namespace MPuget\blog\controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;
use MPuget\blog\Utils\Mail;

class MainController extends CoreController
{
    protected $userRepo;
    protected $twig;

    public function __construct(){
        $this->userRepo = new UserRepository();
    }

    // une page = une méthode
    public function home()
    {
        var_dump('MainControler::home()');
        $responseMail = null;
        if($_POST) {
            $mail = new Mail;
            $result = $mail->sendMail($_POST);

            if ($result) {
                $result = true;
            } else {
                $result=false;
            }

            $responseMail = $result;
        }

        $this->twig = new Twig();
       
        $userList = $this->userRepo->find(1);
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - Accueil',
            'userList' => $userList,
            'responseMail' => $responseMail
        ];

        echo $this->twig->getTwig()->render('home.twig', $viewData);
       // $this->show('home', $viewData);
    }

    public function contactForm()
    {
        var_dump('MainControler::contactForm()');
        /* $this->twig = new Twig(); */
       
        /* $userList = $this->userRepo->find(1);
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - Accueil',
            'userList' => $userList
        ]; */
        $mail = new Mail();
        $mail->sendMail();
        // echo $this->twig->getTwig()->render('home.twig', $viewData);
       // $this->show('home', $viewData);
    }

}