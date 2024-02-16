<?php

namespace MPuget\blog\Models;

use MPuget\blog\Utils\Database;

// TimeTrait est une class que l'on pourra appeler dans certaines autre classe
// (c'est une forme d'héritage)
// La plus part de nos modèles vont hériter de cette classe / de ce trait !
trait TimeTrait
{
    protected $created_at;
    protected $updated_at;

    /**
     * Get the value of created_at
     */ 
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */ 
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;

        return $this;
    }  

    /**
     * Get the value of updated_at
     */ 
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Set the value of updated_at
     *
     * @return  self
     */ 
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}