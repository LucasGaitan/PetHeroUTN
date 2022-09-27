<?php

namespace Models;

class Postulation{
    private $startDate;
    private $endDate;
    private $hoursPerDay;
    private $description;


    function __construct()
    {
        
    }



    /**
     * Get the value of startDate
     */ 
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * Set the value of startDate
     *
     * @return  self
     */ 
    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * Get the value of endDate
     */ 
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * Set the value of endDate
     *
     * @return  self
     */ 
    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * Get the value of hoursPerDay
     */ 
    public function getHoursPerDay()
    {
        return $this->hoursPerDay;
    }

    /**
     * Set the value of hoursPerDay
     *
     * @return  self
     */ 
    public function setHoursPerDay($hoursPerDay)
    {
        $this->hoursPerDay = $hoursPerDay;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}