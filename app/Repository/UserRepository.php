<?php

namespace MPuget\blog\Repository;

use MPuget\blog\Models\User;
use MPuget\blog\Utils\Database;


class UserRepository extends AbstractRepository
{
    public function findAll(): Array
    {
        $pdoStatement = $this->pdo->prepare('SELECT id FROM `user`');
        $pdoStatement->execute();
        $userList = $pdoStatement->fetchAll();
        $users = [];
        foreach ($userList as $user) {
            $user = $this->find($user['id']);
            $users[] = $user;
        }

        return $users;
    }

    public function find(Int $id): ?User
    {
        $id = intval($id); 
        $pdoStatement = $this->pdo->prepare('SELECT * FROM `user` WHERE id = :id');
        $pdoStatement->execute([
            'id' => $id,
        ]);
        // pour récupérer un seul objet de type User, on utilise 
        // la méthode fetchObject() de PDO !
        $result = $pdoStatement->fetchObject();
        

        if ( !$result ) {
            return $user = null;
        }
        $user = new User();
        
        if (!empty($result)) {
            $user->setId($result->id);
            $user->setRole($result->role);
            $user->setFirstname($result->firstname);
            $user->setLastname($result->lastname);
            if($result->picture) {
                $user->setPicture($result->picture);
            }
            $user->setName();
            $user->setEmail($result->email);
            $user->setPassword($result->password);
            $user->setCreatedAt($result->created_at);
            !empty($result->updated_at) ? $user->setUpdatedAt($result->updated_at) : null;
        }
        
        return $user;
    }

    public function findBy(string $email, string $password): int
    {
        $pdoStatement = $this->pdo->prepare('SELECT * FROM `user` WHERE email = :email AND password = :password');
        $pdoStatement->execute([
            'email'        => $email,
            'password'  => $password
        ]);
        // pour récupérer un seul objet de type User, on utilise 
        // la méthode fetchObject() de PDO !
        $result = $pdoStatement->fetchObject();

        
        if (!empty($result)) {
            return $result->id;
        } else {
            return null;
        }
    }

    public function addUser(User $user): ?User
    {
        $sql = "INSERT INTO user (firstname, lastname, email, password) VALUES (:firstname, :lastname, :picture, :email, :password)";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'firstname' => $user->getFirstname(),
            'lastname'  => $user->getLastname(),
            'picture'  => $user->getPicture(),
            'email'     => $user->getEmail(),
            'password'  => $user->getPassword(),
        ]);

        $userId = Database::getPDO()->lastInsertId();
        $user = $this->find($userId);
        $user->setId($userId);

        return $user;
    }

    public function updateUser(User $user)
    {
        $sql = "UPDATE user SET firstname=:firstname, lastname=:lastname, picture=:picture, email=:email, password=:password, updated_at=:updatedAt
        WHERE id=:id";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id'        => $user->getId(),
            'firstname' => (isset($user->firstname)) ? $user->firstname : $user->getFirstname(),
            'lastname'  => (isset($user->lastname)) ? $user->lastname : $user->getLastname(),
            'picture'  => (isset($user->picture)) ? $user->picture : $user->getPicture(),
            'email'     => (isset($user->email)) ? $user->email : $user->getEmail(),
            'password'  => (isset($user->password)) ? $user->password : $user->getPassword(),
            'updatedAt' => $user->setUpdatedAt(date('Y-m-d H:i:s'))->getUpdatedAt()
        ]);

    }

    public function deleteUser(User $user)
    {
        $id = $user->getid();

        $sql = "DELETE FROM `user` WHERE id = ( :id) ";
        $pdoStatement = $this->pdo->prepare($sql);
        $pdoStatement->execute([
            'id' => $id,
        ]);

        echo('On pleur votre départ ! <br>');
    }
}
