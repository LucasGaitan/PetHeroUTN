<?php

namespace Models;

class Reservation {

    private $id_reservation;
    private $id_guardian;
    private $state;
    private $startDate;
    private $endDate;
    private $concluded;

    function __construct()
    {

    }

    public function getIdReservation()
    {
        return $this->id_reservation;
    }

    public function setIdReservation($id_reservation)
    {
        $this->id_reservation = $id_reservation;
    }

    public function getIdGuardian()
    {
        return $this->id_guardian;
    }

    public function setIdGuardian($id_guardian)
    {
        $this->id_guardian = $id_guardian;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getStartDate()
    {
        return $this->startDate;
    }

    public function setStartDate($startDate)
    {
        $this->startDate = $startDate;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

    public function setEndDate($endDate)
    {
        $this->endDate = $endDate;
    }

    public function getConcluded()
    {
        return $this->concluded;
    }

    public function setConcluded($concluded)
    {
        $this->concluded = $concluded;
    }
}