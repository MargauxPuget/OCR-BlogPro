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
        var_dump('hello');
        $nbPost = $this->postRepo->nbAll();
        $nbPostPerPage = 5;
        $nbPage = ceil($nbPost/$nbPostPerPage);

        if (!isset($params['page'])){
            $params['page'] = 1;
        }

        $postList = $this->postRepo->findAll($nbPostPerPage, $params['page']-1);

        $viewData = [
            'postList'      => $postList,
            'nbPage'        => $nbPage,
            'pageActive'    => $params['page']
        ];

        echo $this->twig->getTwig()->render('post/home.twig', $viewData);
    }

    public function adminAllPost()
    {
        $nbPost = $this->postRepo->nbAll();
        $nbPostPerPage = 20;
        $nbPage = ceil($nbPost/$nbPostPerPage);

       

        $postList = $this->postRepo->findAll($nbPostPerPage, 0);

        $viewData = [
            'postList'      => $postList,
            'nbPage'        => $nbPage,
            'pageActive'    => 0
        ];

        echo $this->twig->getTwig()->render('admin/posts.twig', $viewData);
    }

    public function singlePost($params)
    {
        $postId = $params['postId'];
        $post = $this->postRepo->find($postId);

        $commentList = $this->commentRepo->findAllActiveforOnePost($post);
        $userList = $this->userRepo->findAll();

        $viewData = [
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

        $newPost = $_POST;
        $image = isset($_FILES['picture']) ? $_FILES['picture'] : null ;

        if (
        !isset($newPost['title'])
        || !isset($newPost['chapo'])
        || !isset($newPost['body'])
        ) {
            echo('Il faut un title et un chapo et un article valide pour soumettre le formulaire.');
            return;
        }

        $post = new Post($newPost);

        $user = $this->userRepo->find($_SESSION['userId']);
        $int = intval($user->getId());

        $post->setTitle($newPost['title']);
        if (isset($image)) {
            // Déplacer l'image vers le dossier de destination
            // is_dir('public/assets/images/uploads/') ? var_dump('existe') : var_dump('N existe PAS') ;
            $resultMoveImg = move_uploaded_file($image['tmp_name'], 'public/assets/images/uploads/' . $image['name'] );
            if($resultMoveImg){
                $post->setImage($image['name']);
            }
        }
        $post->setChapo($newPost['chapo']);
        $post->setBody($newPost['body']);
        $post->setUser($user);
        $post->setCreatedAt(date('Y-m-d H:i:s'));


        $post = $this->postRepo->addPost($post);
       
        header('Location: /post/' . $post->getid());
    }

    public function updatedStatusPost($params)
    {
        var_dump($params);
        
        $postId = $params['postId'];
        if (!isset($postId) && !is_int($postId)
            && !isset($params['status'])
            && ($params['status'] === 'archive' || $params['status'] === 'active')
        ) {
            echo("Il faut l'identifiant d'un post.");
            return false;
        }
        $post = $this->postRepo->find($postId);

        $post = $this->postRepo->changedStatusPost($post, $params['status']);

        header('Location: /user/' . $_SESSION['userId']);
    } 

    public function deletePost()
    {
    }

    // ----------- //
    //   Comment   //
    // ----------- //

    public function addComment($params)
    {
        $dataComment = $_POST;

        if (
            !isset($dataComment['body'])
            || !isset($_SESSION['userId'])
        ) {
            echo('Il faut un message et un utilisateur valide pour soumettre le formulaire.');
            return;
        }

        $comment = new Comment();
        $user = $this->userRepo->find($_SESSION['userId']);
        $post = $this->postRepo->find($params['postId']);

        if (!isset($user) || !isset($post)) {
            return;
        }
        
        $comment->setUser($user);
        $comment->setPost($post);
        $comment->setBody($dataComment['body']);
        $comment->setCreatedAt(date('Y-m-d H:i:s'));


        $this->commentRepo->addComment($comment);

        header('Location: /post/' . $params['postId']);
    }

    public function deleteComment($params)
    {
        if (!isset($params['commentId']) && !is_int($params['commentId'])) {
            echo("Il faut l'identifiant d'un commentaire.");
            return false;
        }
        
        $comment = $this->commentRepo->find($params['commentId']);
        if (isset($comment)) {
        $comment = $this->commentRepo->deleteComment($comment);
        }

        header('Location: /post/' . $params['postId']);
    }
}
