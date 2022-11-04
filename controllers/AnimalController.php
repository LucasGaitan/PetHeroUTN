<?php

namespace Controllers;

use DAO\AnimalDAO;
use DAO\OwnerDAO;
use Exception;
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
        session_start();
        try {
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
                $dog->setIdOwner($_SESSION["user"]->getId());

                try {
                    $this->animalDAO->Add($dog);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
            else{
                $cat = new Cat();
                $cat->setName($animalName);
                $cat->setAge($age);
                $cat->setIdAnimalBreed($breed);
                $cat->setPhoto($photo);
                $cat->setVaccinationPlan($vaccinationPlan);
                $cat->setVideo($video);
                $cat->setObservations($observations);
                $cat->setIdAnimalSize($size);
                $cat->setIdOwner($_SESSION["user"]->getId());

                try {
                    $this->animalDAO->Add($cat);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}