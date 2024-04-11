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
        
        // vérifier que l'utilisateur est un admin
        $user = $this->userRepo->find($_SESSION['userId']);
        if ($user->getRole() === 1) {
            // modifier le status du commentaire
            $comment = $this->commentRepo->find($params['commentId']);
        var_dump($_POST['action']);
            if (isset($_POST['action'])
                && (($_POST['action']) === "validated"
                || ($_POST['action']) === "pause"
                || ($_POST['action']) === "refused")
            ) {
                var_dump('ici');
                $comment = $this->commentRepo->changedStatusComment($comment, $_POST['action']);
            }
        }
        header('Location: /user/' . $user->getId());
    }
}