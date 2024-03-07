<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\twig\Twig;
use MPuget\blog\Models\Post;
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
        var_dump($params['page']);
        $postList = $this->postRepo->findAll($nbPostPerPage, $params['page']-1);
        
        $nbPage = ceil($nbPost/$nbPostPerPage);
        var_dump($nbPage);
        var_dump(ceil($nbPage));
        $viewData = [
            'pageTitle'     => 'OCR - Blog - Post',
            'postList'      => $postList,
            'nbPage'        => $nbPage
        ];
        //var_dump($viewData['postList']);

        echo $this->twig->getTwig()->render('post/home.twig', $viewData);
    }

    public function singlePost($params)
    {
        var_dump("PostController->singlePost()");

        $postId = $params['id_post'];
        $post = $this->postRepo->find($postId);

        $viewData = [
            'pageTitle'     => 'OCR - Blog - post',
            'post'          => $post,
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

}