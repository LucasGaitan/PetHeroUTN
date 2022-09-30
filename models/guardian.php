<?php

namespace Models;

use Models\User as User;

class Guardian extends User{

    private $dogTypeExpected;
    private $salaryExpected;
    private $reputation;
    private $postulation;


    function __construct()
    {
        parent::__construct();
        $this->postulation = array();
        $this->dogTypeExpected = array();
    }

    /**
     * Get the value of dogTypeExpected
     */ 
    public function getDogTypeExpected()
    {
        return $this->dogTypeExpected;
    }

    /**
     * Set the value of dogTypeExpected
     *
     * @return  self
     */ 
    public function setDogTypeExpected($dogTypeExpected)
    {
        $this->dogTypeExpected = $dogTypeExpected;

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

    /**
     * Get the value of postulation
     */ 
    public function getPostulation()
    {
        return $this->postulation;
    }

    /**
     * Set the value of postulation
     *
     * @return  self
     */ 
    public function setPostulation($postulation)
    {
        $this->postulation = $postulation;

        return $this;
    }
}
