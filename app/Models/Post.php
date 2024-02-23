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
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
