<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\CommentRepository;

class CommentController
{
    protected $commentRepo;
    protected $userRepo;
    protected $twig;

    public function __construct(){
        $this->userRepo = new UserRepository();
        $this->commentRepo = new CommentRepository();
        $this->twig = new Twig();
    }

    public function updateComment($params) {
        var_dump($_SESSION);
        var_dump($_POST);

        // vérifier que l'utilisateur est un admin
        $user = $this->userRepo->find($_SESSION['userId']);
        if ($user->getRole() === 1) {
            // modifier le status du commentaire
            $comment = $this->commentRepo->find($params['commentId']);
        
            $comment = $this->commentRepo->changedStatusComment($comment, $_POST['action']);
        }
        header('Location: /user/' . $user->getId());
    }

    public function refusedComment($params) {
        var_dump($params);

        // vérifier que l'utilisateur est un admin
        $user = $this->userRepo->find($params['userId']);
        if ($user->getRole() === 1) {
            // modifier le status du commentaire
            $comment = $this->commentRepo->find($params['commentId']);
        
            $comment = $this->commentRepo->changedStatusComment($comment, -1);
        }
        header('Location: /user/' . $user->getId());
    }


    public function acceptedComment($params) {
        var_dump($params);

        // vérifier que l'utilisateur est un admin
        $user = $this->userRepo->find($params['userId']);
        if ($user->getRole() === 1) {
            // modifier le status du commentaire
            $comment = $this->commentRepo->find($params['commentId']);
        
            $comment = $this->commentRepo->changedStatusComment($comment, 1);
        }
        header('Location: /user/' . $user->getId());
    }



}