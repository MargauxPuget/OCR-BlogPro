<?php

namespace MPuget\blog\models;

use PDO;
use MPuget\blog\Models\User;
use MPuget\blog\Models\IdTrait;
use MPuget\blog\Utils\Database;
use MPuget\blog\Models\TimeTrait;

/**
 * repositoryClass=PostRepository::class
 */
class Post
{
    use IdTrait;
    use TimeTrait;

    private ?string $title;
    private ?string $chapo;
    private ?string $body;
    private User $user;

    
    public function __construct()
    {
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getChapo(): ?string
    {
        return $this->chapo;
    }

    public function setChapo(string $chapo): self
    {
        $this->chapo = $chapo;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

	public function getUser(): ?User
    {
        var_dump(isset($this->user));
        if (isset($this->user)) {
            // L'objet utilisateur est créé
            var_dump("L'objet utilisateur est créé", $this);
        return $this->user;
          } else {
            // "L'objet utilisateur n'est pas créé"
            var_dump("L'objet utilisateur N'est PAs créé", $this);
        return null;
          }
    }

    public function setUser(User $user): self
    {
        var_dump($user);
        $this->user = $user;

        return $this;
    }
}
