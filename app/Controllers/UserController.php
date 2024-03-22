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
        $newUser = $_POST;
        if (
        !isset($newUser['firstname'])
        || !isset($newUser['lastname'])
        || !isset($newUser['email'])
        || !filter_var($newUser['email'], FILTER_VALIDATE_EMAIL)
        || !isset($newUser['password'])
        ) {
            echo('Il faut des informations valides pour soumettre le formulaire.');
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
            'user' => $newUser
        ];

        echo $this->twig->getTwig()->render('user/user.twig', $viewData);
    }

    public function userHome()
    {
        if (!isset($_SESSION['userId'])) {
            header('Location: /');
        } else {
            $viewData = [];
            echo $this->twig->getTwig()->render('/user/user.twig', $viewData);
        }
    }
    
    public function loginUser()
    {
        $user = $_POST;
        if (
           !isset($user['email'])
        || !filter_var($user['email'], FILTER_VALIDATE_EMAIL)
        || !isset($user['password'])
        ) {
            echo('Il faut un email et un mot de passe valides pour soumettre le formulaire.');
            return;
        }

        $userList = $this->userRepo->findAll();
        $userLogin;

        foreach ($userList as $key => $user) {
            if (
                   $_POST['email'] === $user->getEmail()
                && $_POST['password'] === $user->getPassword()
            ) {
                $_SESSION['userId'] = $user->getId();
            };
        }

        $viewData = [
            'user' => $user
        ];

        var_dump($_SESSION);
        header('Location: /user/home');
    } 

    public function logoutUser()
    {
        var_dump("UserController->logoutUser()");
        
        unset($_SESSION['userId']);

        header('Location: /');
    }

    public function updateUser()
    {
    } 

    public function deleteUser()
    {
    }
}