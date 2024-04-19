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

    private ?string $status = 'archive';
    private ?string $title;
    private ?string $image;
    private ?string $chapo;
    private ?string $body;
    private User $user;

    
    public function __construct()
    {
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
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

    public function getImage(): ?string
    {
        return isset($this->image) ? $this->image : null ;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

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
        return isset($this->user) ? $this->user : null ;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
