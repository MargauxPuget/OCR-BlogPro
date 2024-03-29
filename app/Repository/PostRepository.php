<?php

namespace MPuget\blog\Repository;

use PDO;
use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Utils\Database;
use MPuget\blog\Repository\UserRepository;


class PostRepository extends AbstractRepository
{
    public function find(Int $id) : Post
    {
        $id = intval($id);
        $pdoStatement = $this->pdo->prepare('SELECT * FROM `post` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);
        $result = $pdoStatement->fetchObject();

        
        $post = new Post();
        if (!empty($result)) {
            $userRepo = new UserRepository();
            $userId = $result->user_id;
            $user = $userRepo->find($userId);
    
            $result->user = $user;

            $post->setId($result->id);
            $post->setTitle($result->title);
            $post->setChapo($result->chapo);
            $post->setBody($result->body);
            if($user) {
                $post->setUser($result->user);
            }
            $post->setCreatedAt($result->created_at);
            $post->setUpdatedAt($result->updated_at);
        }
        echo'<pre>';
        var_dump($post->getUser());
        echo'</pre>';

        return $post;
    }

    public function nbAll() : Int
    {
        $pdoStatement = $this->pdo->prepare('SELECT COUNT(*) FROM `post`');
        $pdoStatement->execute();
        $nbPost = $pdoStatement->fetch();

        return intval($nbPost['COUNT(*)']);
    }

    public function findAll(int $nb=0, int $page=0) : Array
    {
        if ($nb === 0) {
            $pdoStatement = $this->pdo->prepare('SELECT id FROM `post`');
        } else {
            $pdoStatement = $this->pdo->prepare("
                SELECT id
                FROM `post`
                LIMIT :nb OFFSET :offSet
            ");
            $pdoStatement->bindValue(':nb', $nb, PDO::PARAM_INT);
            $pdoStatement->bindValue(':offSet', $page*$nb, PDO::PARAM_INT);
        }

        $pdoStatement->execute();
        $postList = $pdoStatement->fetchAll();
        $posts = [];
        foreach ($postList as $post) {
            $post = $this->find($post['id']);
            $posts[] = $post;
        }
        return $posts;
    }

    public function addPost(Post $post) : Post
    {
        $pdoStatement = $this->pdo->prepare("INSERT INTO post (title, chapo, body, user_id)
        VALUES (:title, :chapo, :body, :userId)");
        $pdoStatement->execute([
            'title'     => $post->getTitle(),
            'chapo'      => $post->getChapo(),
            'body'      => $post->getBody(),
            'userId'    => $post->getUser()->getId(),
        ]);

        $postId = Database::getPDO()->lastInsertId();
        $post = $this->find($postId);

        return $post;
    }

    public function updatePost(Post $post)
    {
        $sql = "UPDATE post SET title=:title, chapo=:chapo, body=:body, user_id=:userId, updated_at=:updatedAt
        WHERE id=:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id'        => $post->getId(),
            'title'     => (isset($updatePost['title'])) ? $updatePost['title'] : $post->getTitle(),
            'chapo'      => (isset($updatePost['chapo'])) ? $updatePost['chapo'] : $post->getChapo(),
            'body'      => (isset($updatePost['body'])) ? $updatePost['body'] : $post->getBody(),
            'userId'    => (isset($updatePost['userId'])) ? $updatePost['userId'] : $post->getUser()->getId(),
            'updatedAt' => $post->setUpdatedAt(date('Y-m-d H:i:s'))->getUpdatedAt()
        ]);
    }

    public function deletePost(Post $post) : bool
    {
        $sql = "DELETE FROM `post` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $post->getId(),
        ]);

        return true;
    }

}
