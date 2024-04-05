<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\CommentRepository;

class UserController
{
    protected $userRepo;
    protected $commentRepo;
    protected $twig;

    public function __construct(){
        $this->userRepo = new UserRepository();
        $this->commentRepo = new CommentRepository();
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
        || !(strlen($newUser['password']) >= 8)
        || !(preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).+$/', $newUser['password'])) //Le mot de passe doit contenir au moins une lettre minuscule, une lettre majuscule et un chiffre.
        ) {
            $validatAddUser = false;
        } else {
            $user = new User();
            $user->setFirstname($newUser['firstname']);
            $user->setLastname($newUser['lastname']);
            $user->setEmail($newUser['email']);
            $user->setPassword(md5($newUser['password']));
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
            die;
        }

        // récupération de cet utilisateur
        $user = $this->userRepo->find($_SESSION['userId']);

        // récupération des commentaires de cet utilisateur
        $commentsByUser = $this->commentRepo->findAllforOneUser($user);

        $viewData = [
            'commentsByUser' => $commentsByUser
        ];
        echo $this->twig->getTwig()->render('/user/user.twig', $viewData);
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

        $resultLogin = $this->userRepo->findBy($user['email'], md5($user['password']));

    
        $viewData = [
            'responceMessage' => "Nous n'avons pas pu vous indientifier !",
            'boolMessage' => false
        ];

        if ($resultLogin != -1) {
            $userLogin = $this->userRepo->find($resultLogin);
            
            $_SESSION['userId'] = $userLogin->getId();

            header('Location: /');
        }

        echo $this->twig->getTwig()->render('home.twig', $viewData);
    } 

    public function logoutUser()
    {
        unset($_SESSION['userId']);
        header('Location: /');
    }

    public function formUser($params)
    {
        $viewData = [];

        if ($params['userId']) {
            // ou veux mettre à jours

            $userId = intval($params['userId']);
            $user = $this->userRepo->find($userId);

            array_push($viewData, ['user' => $user]);
            
        } 
        
        echo $this->twig->getTwig()->render('user/formUser.twig', $viewData);
    }

    public function updateUser()
    {
        if (!isset($_POST['identifiant']) && !is_int($_POST['identifiant'])) {
            echo("Il faut l'identifiant d'un utilisateur.");
            return false;
        }

        $user = $this->userRepo->find($_POST['identifiant']);

        if (isset($_POST['firstname']) && ($_POST['firstname'] !== $user->getFirstname())){
            $user->setFirstname($_POST['firstname']);
        }
        if (isset($_POST['lastname']) && ($_POST['lastname'] !== $user->getLastname())){
            $user->setLastname($_POST['lastname']);
        }
        if (isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)
        && ($_POST['email'] !== $user->getEmail())){
            $user->setEmail($_POST['email']);
        }
        if (isset($_POST['password']) && ($_POST['password'] !== $user->getPassword())){
            $user->setPassword($_POST['password']);
        }      
        
        $this->userRepo->updateUser($user);

        $viewData = [
            'user' => $user
        ];
        $this->twig->setUserSession($user);

        
        // TODO Benoit -> header pour recharger ? mais l'update_a ne se met pas a jour?
        header('Location: /user/' . $user->getId());
        //echo $this->twig->getTwig()->render('user/user.twig', $viewData);

    } 

    public function deleteUser()
    {
    }
}