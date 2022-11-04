<?php

namespace Models;

abstract class Animal{

    private $id_animal;
    private $name;
    private $age;
    private $id_animalBreed;
    private $photo;
    private $vaccinationPlan;
    private $video;
    private $observations;
    private $id_animalSize;
    private $id_owner;

    /**
     * @return mixed
     */
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

    function __construct()
    {
        
    }




    /**
     * @return mixed
     */
    public function getIdAnimal()
    {
        return $this->id_animal;
    }

    /**
     * @param mixed $id_animal
     */
    public function setIdAnimal($id_animal)
    {
        $this->id_animal = $id_animal;
    }

    /**
     * @return mixed
     */
    public function getIdAnimalBreed()
    {
        return $this->id_animalBreed;
    }

    /**
     * @param mixed $id_animalBreed
     */
    public function setIdAnimalBreed($id_animalBreed)
    {
        $this->id_animalBreed = $id_animalBreed;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getVaccinationPlan()
    {
        return $this->vaccinationPlan;
    }

    /**
     * @param mixed $vaccinationPlan
     */
    public function setVaccinationPlan($vaccinationPlan)
    {
        $this->vaccinationPlan = $vaccinationPlan;
    }

    /**
     * @return mixed
     */
    public function getVideo()
    {
        return $this->video;
    }

    /**
     * @param mixed $video
     */
    public function setVideo($video)
    {
        $this->video = $video;
    }

    /**
     * @return mixed
     */
    public function getObservations()
    {
        return $this->observations;
    }

    /**
     * @param mixed $observations
     */
    public function setObservations($observations)
    {
        $this->observations = $observations;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of age
     */ 
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set the value of age
     *
     * @return  self
     */ 
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get the value of size
     */ 
    public function getIdAnimalSize()
    {
        return $this->id_animalSize;
    }

    /**
     * Set the value of size
     *
     * @return  self
     */ 
    public function setIdAnimalSize($id_animalSize)
    {
        $this->id_animalSize = $id_animalSize;

        return $this;
    }
}