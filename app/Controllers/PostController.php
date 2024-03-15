<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\Comment;
use MPuget\blog\Models\TimeTrait;
use MPuget\blog\Repository\PostRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\CommentRepository;

class PostController
{
    protected $postRepo;
    protected $userRepo;
    protected $commentRepo;
    protected $twig;

    public function __construct(){
        $this->twig = new Twig();
        $this->postRepo = new PostRepository();
        $this->userRepo = new UserRepository();
        $this->commentRepo = new CommentRepository();
    }

    public function home($params)
    {
        var_dump('PostControler->home()');
        $nbPost = $this->postRepo->nbAll();
        $nbPostPerPage = 5;
        $nbPage = ceil($nbPost/$nbPostPerPage);

        if (!isset($params['page'])){
            $params['page'] = 1;
        }

        $postList = $this->postRepo->findAll($nbPostPerPage, $params['page']-1);
        
        $viewData = [
            'pageTitle'     => 'OCR - Blog - Post',
            'postList'      => $postList,
            'nbPage'        => $nbPage,
            'pageActive'    => $params['page']
        ];

        echo $this->twig->getTwig()->render('post/home.twig', $viewData);
    }

    public function singlePost($params)
    {
        var_dump("PostController->singlePost()");

        $postId = $params['postId'];
        $post = $this->postRepo->find($postId);

        $commentList = $this->commentRepo->findAllforOnePost($post);
        $userList = $this->userRepo->findAll();

        $viewData = [
            'pageTitle'     => 'OCR - Blog - post',
            'post'          => $post,
            'commentList'   => $commentList,
            'userList'      => $userList
        ];

        echo $this->twig->getTwig()->render('post/post.twig', $viewData);
    }
    
    public function formPost()
    {
    }

    public function addPost()
    {
    }

    public function updatePost()
    {
    } 

    public function deletePost()
    {
    }

    // ----------- //
    //   Comment   //
    // ----------- //

    public function addComment($params)
    {
        var_dump("PostController->addComment()");
var_dump($_POST);
        if (
            !isset($_POST['body'])
            || !isset($_POST['userId'])
        ) {
            echo('Il faut un message et un utilisateur valide pour soumettre le formulaire.');
            return;
        }

        $comment = new Comment();
        $user = $this->userRepo->find($_POST['userId']);
        $post = $this->postRepo->find($params['postId']);

        $comment->setBody($_POST['body']);
        $comment->setUser($user);
        $comment->setPost($post);
        $comment->setCreatedAt(date('Y-m-d H:i:s'));

        $comment = $this->commentRepo->addComment($comment);

        // TODO Benoit je sais pas si j'ai le droit de faire ça ? 
        $this->singlePost($params);
    }

    public function deleteComment($params)
    {
        var_dump("PostController->deleteComment()");

        if (!isset($params['commentId']) && !is_int($params['commentId'])) {
            echo("Il faut l'identifiant d'un commentaire.");
            return false;
        }
        
        $comment = $this->commentRepo->find($params['commentId']);

        $comment = $this->commentRepo->deleteComment($comment);

        // TODO Benoit je sais pas si j'ai le droit de faire ça ? 
        $this->singlePost($params);
    }
}
