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

    /**
     * @param array $dogs
     */
    public function setDogs(array $dogs)
    {
        $this->dogs = $dogs;
    }


}