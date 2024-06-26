<?php

namespace MPuget\blog\Repository;

use PDO;
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

    public function nbAll() : Int
    {
        $pdoStatement = $this->pdo->prepare('SELECT COUNT(*) FROM `comment`');
        $pdoStatement->execute();
        $nbComment = $pdoStatement->fetch();

        return intval($nbComment['COUNT(*)']);
    }




    public function findAll(int $nb=0, int $page=0) : Array
    {
        if ($nb === 0) {
            $pdoStatement = $this->pdo->prepare('
                SELECT id
                FROM `comment`
                ORDER BY id DESC
            ');
        } else {
            $pdoStatement = $this->pdo->prepare("
                SELECT id
                FROM `comment`
                ORDER BY id DESC
                LIMIT :nb OFFSET :offSet
            ");
            $pdoStatement->bindValue(':nb', $nb, PDO::PARAM_INT);
            $pdoStatement->bindValue(':offSet', $page*$nb, PDO::PARAM_INT);
        }

        $pdoStatement->execute();
        $commentList = $pdoStatement->fetchAll();
        $comments = [];
        foreach ($commentList as $comment) {
            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }



    

    public function findAllActiveforOnePost(Post $post): ?Array
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `comment`
        WHERE post_id=:postId AND status=:status ORDER BY `created_at` DESC');
        $pdoStatement->execute([
            "postId" => $post->getId(),
            "status" => 1,
        ]);
        $commentList = $pdoStatement->fetchAll();

        $comments = [];
        foreach ($commentList as $comment) {

            $comment = $this->find($comment['id']);
            $comments[] = $comment;
        }
        
        return $comments;
    }

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
        $pdoStatement = $this->pdo->prepare("INSERT INTO comment (status, body, user_id, post_id)
        VALUES (:status, :body, :userId, :postId)");
        $pdoStatement->execute([
            'status' => $comment->getStatus(),
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

        $sql = "UPDATE comment SET status=:status
        WHERE id=:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id'        => $comment->getId(),
            'status'    => $codeStatus,
        ]);

        return true;
    }
}
