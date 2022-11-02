<?php

namespace Models;

use Models\User as User;

class Guardian extends User{
    private $idGuardian;
    private $id_animal_size_expected;
    private $salaryExpected;
    private $reputation;
    private $postulation;


    function __construct()
    {
        parent::__construct();
        $this->postulation = array();
        //$this->dogTypeExpected = array();
    }

    /**
     * Get the value of dogTypeExpected
     */ 
    public function getId_animal_size_expected()
    {
        return $this->id_animal_size_expected;
    }

    /**
     * Set the value of dogTypeExpected
     *
     * @return  self
     */ 
    public function setId_animal_size_expected($id_animal_size_expected)
    {
        $this->id_animal_size_expected = $id_animal_size_expected;

        return $this;
    }

    /**
     * Get the value of salaryExpected
     */ 
    public function getSalaryExpected()
    {
        return $this->salaryExpected;
    }

    /**
     * Set the value of salaryExpected
     *
     * @return  self
     */ 
    public function setSalaryExpected($salaryExpected)
    {
        $this->salaryExpected = $salaryExpected;

        return $this;
    }

    /**
     * Get the value of reputation
     */ 
    public function getReputation()
    {
        return $this->reputation;
    }

    /**
     * Set the value of reputation
     *
     * @return  self
     */ 
    public function setReputation($reputation)
    {
        $this->reputation = $reputation;

        return $this;
    }

    public function getPostulation()
    {
        return $this->postulation;
    }


    public function setPostulation($postulation)
    {
        if(empty($this->postulation[0]))
        {
            $this->postulation[0] = $postulation;
        }
        else
        {
            $this->postulation[] = $postulation;
        }
    }

    public function setAllPostulations(array $postulationArray)
    {
        $this->postulation = [];

        foreach ($postulationArray as $aux)
        {
            $postulation = new Postulation();
            $postulation->setStartDate($aux["startDate"]);
            $postulation->setEndDate($aux["endDate"]);
            $postulation->setHoursPerDay($aux["hoursPerDay"]);
            $postulation->setDescription($aux["description"]);

            $this->postulation[] = $postulation;
        }
    }
}
