<?php

namespace Controllers;

use Exception;
use Models\reservation as Reservation;
use DAO\ReservationDAO as ReservationDAO;

class ReservationController
{
    private $reservationDAO;

    public function __construct()
    {
        $this->reservationDAO = new ReservationDAO();
    }

    public function ReservationForm($startDate, $endDate, $id_animal, $idGuardian)
    {
        $startDate2 = strtotime($startDate);
        $endDate2 = strtotime($endDate);

        if($startDate2 <= $endDate2)
        {
            $reservation = new reservation();
            $reservation->setIdGuardian($idGuardian);
            $reservation->setStartDate($startDate);
            $reservation->setEndDate($endDate);
            $reservation->setState(0);
            $reservation->setConcluded(0);

            $reservation_animals = ["reservation"=>$reservation, "id_animal"=>$id_animal];
            try {
                $this->reservationDAO->add($reservation_animals);
                header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=1");
            } catch (Exception $e) {
                echo $e->getMessage();
            }
        }
        else {
            //Mostrar alerta de que no puede tener la fecha de inicio despues de la fecha de final.
            session_start();
            header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=3");
        }

//        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }
    public function ConfirmReservation($idReservation)
    {
        try {
            $this->reservationDAO->updateState($idReservation);
            header("location: " . FRONT_ROOT . "Guardian/showActionMenu?value=2");
        } catch (Exception $e) {
            #MANDAR ALERT
            echo $e->getMessage();
        }
    }

    public function guardianSelected($idGuardian, $userGuardian, $startDate, $endDate)
    {
        session_start();
        $val = 3;

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function reservationSelected($idReservation)
    {
        session_start();
        $val = 2;

        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }


    public function getAllReservationsByGuardianId ()
    {
        try {
            return $this->reservationDAO->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());
        } catch (Exception $e) {
            #MANDAR ALERT
            echo $e->getMessage();
        }
    }

}