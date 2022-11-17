<?php

namespace Models;

abstract class Animal{

    private $id_animal;
    private $name;
    private $age;
    private $type;
    private $id_animalBreed;
    private $breed;
    private $photo;
    private $vaccinationPlan;
    private $video;
    private $observations;
    private $id_animalSize;
    private $size;
    private $id_owner;


    function __construct()
    {

    }

    public function getIdOwner()
    {
        return $this->id_owner;
    }

    /**
     * @param mixed $id_owner
     */
    public function setIdOwner($id_owner)
    {
        $this->id_owner = $id_owner;
    }

    public function getIdAnimal()
    {
        return $this->id_animal;
    }

    public function setIdAnimal($id_animal)
    {
        $this->id_animal = $id_animal;
    }

    public function getIdAnimalBreed()
    {
        return $this->id_animalBreed;
    }

    public function setIdAnimalBreed($id_animalBreed)
    {
        $this->id_animalBreed = $id_animalBreed;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    public function getVaccinationPlan()
    {
        return $this->vaccinationPlan;
    }

    public function setVaccinationPlan($vaccinationPlan)
    {
        $this->vaccinationPlan = $vaccinationPlan;
    }

    public function getVideo()
    {
        return $this->video;
    }

    public function setVideo($video)
    {
        $this->video = $video;
    }

    public function getObservations()
    {
        return $this->observations;
    }

    public function setObservations($observations)
    {
        $this->observations = $observations;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    public function getIdAnimalSize()
    {
        return $this->id_animalSize;
    }

    public function setIdAnimalSize($id_animalSize)
    {
        $this->id_animalSize = $id_animalSize;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function getBreed()
    {
        return $this->breed;
    }

    public function setBreed($breed)
    {
        $this->breed = $breed;
    }

    public function getSize()
    {
        return $this->size;
    }

    public function setSize($size)
    {
        $this->size = $size;
    }
}