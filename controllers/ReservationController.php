<?php

namespace Controllers;

use Controllers\GuardianController as GuardianController;
use DAO\GuardianDAO as GuardianDAO;
use Exception;
use Models\reservation as Reservation;
use DAO\ReservationDAO as ReservationDAO;

class ReservationController
{
    private $reservationDAO;
    private $guardianDAO;

    public function __construct()
    {
        $this->reservationDAO = new ReservationDAO();
        $this->guardianDAO = new GuardianDAO();
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
        session_start();

        try {
            $confirmed = $this->reservationDAO->updateState($idReservation);

            if($confirmed == 1)
            {
                $infoCoupon = $this->guardianDAO->bringSalaryExpected($_SESSION["user"]->getIdGuardian(), $idReservation);

                $salaryExpected = $infoCoupon["salaryExpected"];
                $startDate = strtotime($infoCoupon["startDate"]);
                $endDate = strtotime($infoCoupon["endDate"]);

                $secondsPerDay = 86400;
                $numberOfSecondsRangeDate = ($endDate - $startDate);
                $numberOfDaysWorked = ($numberOfSecondsRangeDate / $secondsPerDay);

                $total = ($numberOfDaysWorked * $salaryExpected);

                $this->reservationDAO->createCoupon($idReservation, $total);
            }

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

        $guardianController = new GuardianController();
        $listGuardian = $guardianController->getAllGuardians();

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function reservationSelected($idReservation)
    {
        session_start();
        $val = 2;

        try {
            $reservations = $this->reservationDAO->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());
        } catch (Exception $e) {
            #ALERT
        }

        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function confirmedReservationSelected($idGuardian)
    {
        session_start();
        $val = 4;

        try {
            $listConfirmedReservations = $this->reservationDAO->getConfirmedReservationsByGuardian($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
        }

        if(!is_null($listConfirmedReservations))
            $selectConfirmed = true;

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }
}