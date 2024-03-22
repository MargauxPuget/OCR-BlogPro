<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;

class UserController
{
    protected $userRepo;
    protected $twig;

    public function __construct(){
        $this->userRepo = new UserRepository();
        $this->twig = new Twig();
    }

    public function addUser()
    {
        var_dump("UserController->addUser()");

        $newUser = $_POST;
        if (
        !isset($newUser['firstname'])
        || !isset($newUser['lastname'])
        || !isset($newUser['email'])
        || !filter_var($newUser['email'], FILTER_VALIDATE_EMAIL)
        || !isset($newUser['password'])
        ) {
            echo('Il faut un email et un message valide pour soumettre le formulaire.');
            return;
        }

        $user = new User();
        $user->setFirstname($newUser['firstname']);
        $user->setLastname($newUser['lastname']);
        $user->setEmail($newUser['email']);
        $user->setPassword($newUser['password']);
        $user->setCreatedAt(date('Y-m-d H:i:s'));

        $newUser = $this->userRepo->addUser($user);

        $viewData = [
            'pageTitle' => 'OCR - Blog - user',
            'user' => $newUser
        ];

        echo $this->twig->getTwig()->render('user/user.twig', $viewData);
    }

    public function updateUser()
    {
    } 

    public function deleteUser()
    {
    }
}