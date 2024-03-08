<?php

namespace MPuget\blog\Controllers;

use MPuget\blog\Models\Comment;
use MPuget\blog\Repository\PostRepository;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\CommentRepository;

class CommentController
{
    protected $commentRepo;
    protected $postRepo;
    protected $userrepo;

    public function __construct(){
        $this->postRepo = new PostRepository();
		$this->commentRepo = new CommentRepository();
        $this->userRepo = new UserRepository();
    }

    public function formComment()
    {
    }

    public function updateComment()
    {
    } 

    public function addComment($params)
    {
        var_dump("CommentController->addComment()");
        
		$newComment = $this->commentRepo->addComment();

        $post = $this->postRepo->find($newComment->getPost()->getId());

        $userList = $this->userRepo->findAll();
        $commentList = $this->commentRepo->findAllforOnePost($post);

        $viewData = [
            'pageTitle' => 'OCR - Blog - comment - add',
			'post'      => $post,
            //'comment'   => $newComment,
            'commentList'  => $commentList,
            'userList'  => $userList,
        ];

        $this->show('post/post', $viewData);
    }

    public function deleteComment()
    {
        var_dump("CommentController->deleteComment()");

        $postData = $_POST;

        if (!isset($postData['identifiant']) && !is_int($postData['identifiant'])) {
            echo("Il faut l'identifiant d'un commentaire.");
            return false;
        }
        
        $comment = $this->commentRepo->find($postData['identifiant']);

        $comment = $this->commentRepo->deleteComment($comment);

        $viewData = [
            'pageTitle' => 'OCR - Blog - comment - delete',
            'comment' => $comment
        ];

        echo $this->twig->getTwig()->render('comment/deleteComment.twig', $viewData);
    }

}