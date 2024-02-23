<?php

namespace MPuget\blog\Models;

trait IdTrait
{
    // ici on va définir toutes les propriétés & méthodes communes à tous nos modèles !

    private $id;

    public function getId() : ?integer
    {
        return $this->id;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setId($id) : ?self
    {
        $this->id = $id;

        return $this;
    }  
}