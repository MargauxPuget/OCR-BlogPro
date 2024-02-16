<?php

namespace MPuget\blog\Models;

trait IdTrait
{
    // ici on va définir toutes les propriétés & méthodes communes à tous nos modèles !

    private $id;

    /**
     * Get the value of id
     * 
     * @return Integer Id du produit
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }  
}