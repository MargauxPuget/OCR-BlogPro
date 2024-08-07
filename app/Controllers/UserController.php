<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\PostRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\CommentRepository;

class UserController
{
    protected $userRepo;
    protected $postRepo;
    protected $commentRepo;
    protected $twig;

    public function __construct(){
        $this->userRepo = new UserRepository();
        $this->commentRepo = new CommentRepository();
        $this->postRepo = new PostRepository();
        $this->twig = new Twig();
    }

    public function addUser()
    {
        $newUser = $_POST;
        $image = isset($_FILES['picture']) ? $_FILES['picture'] : null ;
       
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

            if (isset($image)) {
                // Déplacer l'image vers le dossier de destination
                // is_dir('public/assets/images/uploads/') ? var_dump('existe') : var_dump('N existe PAS') ;
                $resultMoveImg = move_uploaded_file($image['tmp_name'], 'public/assets/images/uploads/' . $image['name'] );
                if($resultMoveImg){

                    $user->setPicture($image['name']);
                }
            }

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
        $sessionUser = $this->userRepo->getSessionUser();

        // récupération des commentaires de cet utilisateur
        $commentsByUser = $this->commentRepo->findAllforOneUser($sessionUser);
        // récupération des commentaires de cet utilisateur
        $commentsForValidation = $this->commentRepo->findAllforOneUser($sessionUser, 0);
        // récupération des commentaires de cet utilisateur
        $allPosts = $this->postRepo->findFromStatus('active', 3);

        $viewData = [
            'allPosts' => $allPosts,
            'commentsByUser' => $commentsByUser,
            'commentsForValidation' => $commentsForValidation

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

            $viewData = ['user' => $user];
        }
        
        echo $this->twig->getTwig()->render('user/formUser.twig', $viewData);
    }

    public function updateUser()
    {
        $updatDataUser = $_POST;
        if (!isset($updatDataUser['identifiant']) && !is_int($updatDataUser['identifiant'])) {
            echo("Il faut l'identifiant d'un utilisateur.");
            header('Location: /user/' . $updatDataUser->getId());
            return false;
        }

        $userLogin = $this->userRepo->find($_SESSION['userId']);
        $userChange = $this->userRepo->find($updatDataUser['identifiant']);

        // on vérifier que la personne qui veut modifier un user soit cet user, ou une personne admin
        if(!($updatDataUser['identifiant'] == $userLogin->getId()) && !($userLogin->getRole() === 1) ){
            echo("Vous ne pouvez pas modifier cette personne");
            header('Location: /user/' . $userLogin->getId());
            return false;
        }

        if (isset($updatDataUser['firstname']) && ($updatDataUser['firstname'] !== $userChange->getFirstname())){
            $userChange->setFirstname($updatDataUser['firstname']);
        }
        if (isset($updatDataUser['lastname']) && ($updatDataUser['lastname'] !== $userChange->getLastname())){
            $userChange->setLastname($updatDataUser['lastname']);
        }

        $image = $_FILES['picture'];
        if (isset($image) && ($image['error'] === 0)){
            // Déplacer l'image vers le dossier de destination
            //is_dir('public/assets/images/uploads/') ? var_dump('existe') : var_dump('N existe PAS') ;

            move_uploaded_file($image['tmp_name'], 'public/assets/images/uploads/' . $image['name'] );
            
            $userChange->setPicture($image['name']);
        }

        if (isset($updatDataUser['email']) || !filter_var($updatDataUser['email'], FILTER_VALIDATE_EMAIL)
        && ($updatDataUser['email'] !== $userChange->getEmail())){
            $userChange->setEmail($updatDataUser['email']);
        }
        if (isset($updatDataUser['password']) && ($updatDataUser['password'] !== $userChange->getPassword())){ 
            $userChange->setPassword($updatDataUser['password']);
        }      
        
        $this->userRepo->updateUser($userChange);

        $viewData = [
            'user' => $userChange
        ];

        // on vérifier que la personne qui veut modifier un user soit cet user, ou une personne admin
        if($updatDataUser['identifiant'] == $userLogin->getId()){
            $this->twig->setUserSession($userLogin);
        }

        header('Location: /user/' . $userLogin->getId());
    } 

    public function deleteUser()
    {}

    public function formPost($params)
    {
        $sessionUser = $this->userRepo->getSessionUser();
        if (
            $params['userId'] != $sessionUser->getId()
            || !($sessionUser->getRole() == 1)
        ){
            header('Location: /');
            return;
        }

        $postId =  isset($params['postId']) ? $params['postId'] : null  ;
        $post =  isset($postId) ? $this->postRepo->find($postId) : null;

        $viewData = [
            'updatePost' => false,
            'post'       => $post,
        ];

        echo $this->twig->getTwig()->render('post/formPost.twig', $viewData);
    }
}