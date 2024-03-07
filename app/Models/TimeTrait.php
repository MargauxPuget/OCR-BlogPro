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

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt($created_at) : self
    {
        $this->created_at = $created_at;

        return $this;
    }  

    public function getUpdatedAt() : self
    {
        return $this->updated_at;
    }

    public function setUpdatedAt($updated_at) :self
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
