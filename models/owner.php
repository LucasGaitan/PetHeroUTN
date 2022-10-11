<?php

namespace Models;

use Models\User as User;

class Owner extends User
{
    private $dogs;

    function __construct()
    {
        parent::__construct();
        $this->dogs = array();
    }

    /**
     * @return array
     */
    public function getDogs(): array
    {
        return $this->dogs;
    }

    public function setDogs($dog)
    {
        if(empty($this->dogs[0]))
        {
            $this->dogs[0] = $dog;
        }
        else
        {
            $this->dogs[] = $dog;
        }
    }


}