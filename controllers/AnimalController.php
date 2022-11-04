<?php

namespace Controllers;

use DAO\AnimalDAO;
use DAO\OwnerDAO;
use Models\Cat;
use Models\Owner;
use Models\Dog;

class AnimalController
{
    private $ownerDAO;
    private $animalDAO;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->animalDAO = new AnimalDAO();
    }

    public function animalForm($animalName, $age, $breed, $photo, $vaccinationPlan, $video, $observations, $size)
    {
        if ($this->animalDAO->getTypeFromBreed($breed) === 1) {
            $dog = new Dog();
            $dog->setName($animalName);
            $dog->setAge($age);
            $dog->setIdAnimalBreed($breed);
            $dog->setPhoto($photo);
            $dog->setVaccinationPlan($vaccinationPlan);
            $dog->setVideo($video);
            $dog->setObservations($observations);
            $dog->setIdAnimalSize($size);

            echo "<pre>";
            var_dump($dog);
            echo "</pre>";

        }
    }
}