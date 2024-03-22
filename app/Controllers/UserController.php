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
        empty($newUser['firstname'])
        || empty($newUser['lastname'])
        || empty($newUser['email'])
        || !filter_var($newUser['email'], FILTER_VALIDATE_EMAIL)
        || empty($newUser['password'])
        ) {
            $validatAddUser = false;
        } else {
            $user = new User();
            $user->setFirstname($newUser['firstname']);
            $user->setLastname($newUser['lastname']);
            $user->setEmail($newUser['email']);
            $user->setPassword($newUser['password']);
            $user->setCreatedAt(date('Y-m-d H:i:s'));

            $newUser = $this->userRepo->addUser($user);

            $validatAddUser = true;
        }

        $viewData = [
            'user' => $newUser,
            'responceMessage' => $validatAddUser ? 'Votre compte à biee était créé' : 'Certains champs ne sont pas corrects !',
            'boolMessage' => $validatAddUser ? true : false
        ];

        echo $this->twig->getTwig()->render('home.twig', $viewData);
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

        $resultLogin = $this->userRepo->findBy($user['email'], $user['password']);

    
        if ($resultLogin != -1) {
            $userLogin = $this->userRepo->find($resultLogin);
            
            $_SESSION['userId'] = $userLogin->getId();

            $viewData = [
                'user' => $userLogin,
                'responceMessage' => "Vous êtes connecté(e) !",
                'boolMessage' => true
            ];
        } else {
            $viewData = [
                'responceMessage' => "Nous n'avons pas pu vous indientifier !",
                'boolMessage' => false
            ];
        }

        echo $this->twig->getTwig()->render('home.twig', $viewData);
    } 

    public function logoutUser()
    {
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