<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\Comment;
use MPuget\blog\Models\User;
use MPuget\blog\Models\Post;
use MPuget\blog\Utils\Database;
use MPuget\blog\Repository\UserRepository;
use MPuget\blog\Repository\PostRepository;


class CommentRepository extends AbstractRepository
{
    public function find(Int $id): ?Comment
    {
        $id = intval($id);

        $pdoStatement = $this->pdo->prepare('SELECT * FROM `comment` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);
        $result = $pdoStatement->fetchObject();

        $comment = new Comment();
        if (!empty($result)) {
            $userRepo = new UserRepository();
            $userId = $result->user_id;
            $user = $userRepo->find($userId);
            $result->user = $user;

            $postRepo = new postRepository();
            $postId = $result->post_id;
            $post = $postRepo->find($postId);
            $result->post = $post;

            $comment->setId($result->id);
            $comment->setStatus($result->status);
            $comment->setBody($result->body);
            $comment->setUser($result->user);
            $comment->setPost($result->post);
            $comment->setCreatedAt($result->created_at);
            $comment->setUpdatedAt($result->updated_at);
        }

        return $comment;
    }

    public function findAll(): Post
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`');
        $pdoStatement->execute();
        $commentList = $pdoStatement->fetchAll();
        $comments = [];
        foreach ($commentList as $comment) {
            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public function findAllforOnePost(Post $post): ?Array
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`
        WHERE post_id=:postId ORDER BY `created_at` DESC');
        $pdoStatement->execute([
            "postId" => $post->getId(),
        ]);
        $commentList = $pdoStatement->fetchAll();

        $comments = [];
        foreach ($commentList as $comment) {

            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }

<<<<<<< HEAD
    public function findAllforOneUser(User $user, int $status = null): ?Array
    {
        if (isset($status)) {
            $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`
            WHERE status=:source ORDER BY `created_at` DESC');
            $pdoStatement->execute([
                "source" => $status,
            ]);
        } else {
            $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`
            WHERE user_id=:user_id ORDER BY `created_at` DESC');
            $pdoStatement->execute([
                "user_id" => $user->getId(),
            ]);
        }

=======
    public function findAllforOneUser(User $user): ?Array
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`
        WHERE user_id=:userId ORDER BY `created_at` DESC');
        $pdoStatement->execute([
            "userId" => $user->getId(),
        ]);
>>>>>>> 7a5cdce (display comment in user page)
        $commentList = $pdoStatement->fetchAll();

        $comments = [];
        foreach ($commentList as $comment) {

            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public function findAllForValidation(int $status): ?Array
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`
        WHERE status=:status ORDER BY `created_at` DESC');
        $pdoStatement->execute([
            "status" => $status,
        ]);
        $commentList = $pdoStatement->fetchAll();

        $comments = [];
        foreach ($commentList as $comment) {

            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }

    public function addComment($comment)
    {
        $pdoStatement = $this->pdo->prepare("INSERT INTO comment (body, user_id, post_id)
        VALUES (:body, :userId, :postId)");
        $pdoStatement->execute([
            'body' => $comment->getBody(),
            'userId'  => intval($comment->getUser()->getId()),
            'postId'  => intval($comment->getPost()->getId()),
        ]);

        $commentId = Database::getPDO()->lastInsertId();
        $comment = $this->find($commentId);

        unset($_POST);
        
        return $comment;
    }

    public function deleteComment(Comment $comment) : bool
    {
        $sql = "DELETE FROM `comment` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $comment->getId(),
        ]);

        return true;
    }

<<<<<<< HEAD
    public function changedStatusComment(Comment $comment, string $newStatus) : bool
    {
        $codeStatus = null;
        switch ($newStatus) {
            case 'refused':
                $codeStatus = -1;
                break;
            case 'pause':
                $codeStatus = 0;
                break;
            case 'validated':
                $codeStatus = 1;
                break;
        }

=======
    public function changedStatusComment(Comment $comment, int $newStatus) : bool
    {
>>>>>>> 5901fef (change status of comments)
        $sql = "UPDATE comment SET status=:status
        WHERE id=:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id'        => $comment->getId(),
<<<<<<< HEAD
            'status'    => $codeStatus,
=======
            'status'    => $newStatus,
>>>>>>> 5901fef (change status of comments)
        ]);

        return true;
    }

}
