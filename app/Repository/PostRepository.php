<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\Post;
use MPuget\blog\Models\User;
use MPuget\blog\Utils\Database;
use MPuget\blog\Repository\UserRepository;


class PostRepository extends AbstractRepository
{

    /**
     * find() permet de récupérer un produit spécifique par son id
     * 
     * @param Integer id du produit à récupérer
     * @return Post
     */
    public function find($id)
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
            $post->setBody($result->body);
            $post->setUser($result->user);
            $post->setCreatedAt($result->created_at);
            $post->setUpdatedAt($result->updated_at);
        }

        return $post;
    }

    /**
     * findAll() permet de récupérer tous les enregistrement de la table product
     * 
     * @return Post[]
     */
    public function findAll()
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `post`');
        $pdoStatement->execute();
        $postList = $pdoStatement->fetchAll();
        $posts = [];
        foreach ($postList as $post) {
            $post = $this->find($post['id']);
            $posts[] = $post;
        }
        return $posts;
    }

    public function addPost(Post $post)
    {
        var_dump("PostRepository->addPost()");


        $pdoStatement = $this->pdo->prepare("INSERT INTO post (title, body, user_id)
        VALUES (:title, :body, :userId)");
        $pdoStatement->execute([
            'title'     => $post->getTitle(),
            'body'      => $post->getBody(),
            'userId'    => $post->getUser()->getId(),
        ]);

        $postId = Database::getPDO()->lastInsertId();
        $post = $this->find($postId);

        return $post;
    }

    public function updatePost(Post $post)
    {
        var_dump("PostRepository->updatePost()");

        $sql = "UPDATE post SET title=:title, body=:body, user_id=:userId, updated_at=:updatedAt
        WHERE id=:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id'        => $post->getId(),
            'title'     => (isset($updatePost['title'])) ? $updatePost['title'] : $post->getTitle(),
            'body'      => (isset($updatePost['body'])) ? $updatePost['body'] : $post->getBody(),
            'userId'    => (isset($updatePost['userId'])) ? $updatePost['userId'] : $post->getUser()->getId(),
            'updatedAt' => $post->setUpdatedAt(date('Y-m-d H:i:s'))->getUpdatedAt()
        ]);
    }

    public function deletePost(Post $post) : bool
    {
        var_dump("PostRepository->deletePost()");

        $sql = "DELETE FROM `post` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $post->getId(),
        ]);

        return true;

    }

}
