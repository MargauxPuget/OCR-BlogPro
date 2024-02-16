<?php

namespace MPuget\blog\controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Controllers\CoreController;

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
        $this->twig = new Twig();
       
        $userList = $this->userRepo->find(1);
        
        $viewData = [
            'pageTitle' => 'OCR - Blog - Accueil',
            'userList' => $userList
        ];

        echo $this->twig->getTwig()->render('home.twig', $viewData);
       // $this->show('home', $viewData);
    }

}