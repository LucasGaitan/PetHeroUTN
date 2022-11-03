<?php

namespace Models;

use Models\User as User;

class Guardian extends User{

    private $idGuardian;
    private $id_animal_size_expected;
    private $salaryExpected;
    private $reputation;
    private $starDate;
    private $endDate;

    function __construct()
    {
        parent::__construct();
    }

    public function getIdGuardian()
    {
        return $this->idGuardian;
    }

    public function setIdGuardian($idGuardian)
    {
        $this->idGuardian = $idGuardian;
    }

    public function getStarDate()
    {
        return $this->starDate;
    }

    public function setStarDate($starDate)
    {
        $this->starDate = $starDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getId_animal_size_expected()
    {
        return $this->id_animal_size_expected;
    }

    public function setId_animal_size_expected($id_animal_size_expected)
    {
        $this->id_animal_size_expected = $id_animal_size_expected;
        return $this;
    }

    public function getSalaryExpected()
    {
        return $this->salaryExpected;
    }

    public function setSalaryExpected($salaryExpected)
    {
        $this->salaryExpected = $salaryExpected;

        return $this;
    }

    public function getReputation()
    {
        return $this->reputation;
    }

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

//    public function setAllPostulations(array $postulationArray)
//    {
//        $this->postulation = [];
//
//        foreach ($postulationArray as $aux)
//        {
//            $postulation = new Postulation();
//            $postulation->setStartDate($aux["startDate"]);
//            $postulation->setEndDate($aux["endDate"]);
//            $postulation->setHoursPerDay($aux["hoursPerDay"]);
//            $postulation->setDescription($aux["description"]);
//
//            $this->postulation[] = $postulation;
//        }
//    }
}
