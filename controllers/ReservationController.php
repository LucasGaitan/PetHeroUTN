<?php

namespace Controllers;

use Models\Reservation as Reservation;
use DAO\ReservationDAO as ReservationDAO;

class ReservationController
{
    private $reservationDAO;

    public function __construct()
    {
        $this->reservationDAO = new ReservationDAO();
    }

    public function ReservationForm($startDate, $endDate, $pet, $idGuardianSelected)
    {
        $reservation = new Reservation();
        $reservation->setIdGuardian($idGuardianSelected);
        $reservation->setStartDate($startDate);
        $reservation->setEndDate($endDate);
        $reservation->setState(0);
        $reservation->setConcluded(0);

        $this->reservationDAO->createReservation($reservation);
//        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function guardianSelected($idGuardian, $userGuardian)
    {
        session_start();
        $val = 3;

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }


}