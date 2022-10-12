<?php

namespace Controllers;

use DAO\OwnerDAO;
use Models\Owner;
use Models\Dog;

class DogController
{
    private $ownerDAO;
    private $dog;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->dog = new Dog();
    }

    public function dogForm($dogName, $age, $size)
    {
        $this->dog->setName($dogName);
        $this->dog->setAge($age);
        $this->dog->setSize($size);

        $_SESSION['loggedUser']->setDogs($this->dog);

        $this->ownerDAO->Add($_SESSION['loggedUser']);
    }
}