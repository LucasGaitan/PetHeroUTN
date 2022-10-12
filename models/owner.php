<?php

namespace Models;

use Models\User as User;
use Models\Dog as Dog;

class Owner extends User
{
    private $dogs;

    function __construct()
    {
        parent::__construct();
        $this->dogs = [];
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

    public function setAllDogs(array $dogArray)
    {
        $this->dogs = [];

        foreach ($dogArray as $aux)
        {
            $dog = new Dog();
            $dog->setName($aux["name"]);
            $dog->setAge($aux["age"]);
            $dog->setSize($aux["size"]);

            $this->dogs[] = $dog;
        }
    }


}