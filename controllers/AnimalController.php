<?php

namespace Controllers;

use DAO\OwnerDAO;
use Models\Cat;
use Models\Owner;
use Models\Dog;

class AnimalController
{
    private $ownerDAO;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
    }

    public function animalForm($type, $animalName, $age, $photo, $vaccinationPlan, $video, $observations, $size)
    {

    }
}