<?php

namespace Controllers;

use Controllers\GuardianController as GuardianController;
use DAO\GuardianDAO as GuardianDAO;
use DAO\OwnerDAO;
use Exception;
use Models\reservation as Reservation;
use DAO\ReservationDAO as ReservationDAO;

class ReservationController
{
    private $reservationDAO;
    private $ownerController;
    private $guardianController;
    private $guardianDAO;
    private $ownerDAO;

    public function __construct()
    {
        $this->reservationDAO = new ReservationDAO();
        $this->ownerController = new OwnerController();
        $this->guardianController = new GuardianController();
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();

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
                $alert = [
                    "type" => "danger",
                    "text" => $e->getMessage()
                ];
                #QUEDA PENDIENTE VER A DONDE MANDAR
            }
        }
        else {
            $alert = [
                "type" => "danger",
                "text" => "The end date cannot exceed the start date."
            ];
            #QUEDA PENDIENTE VER A DONDE MANDAR
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

                $confirmCreateCoupon = $this->reservationDAO->createCoupon($idReservation, $total);

            }

            header("location: " . FRONT_ROOT . "Guardian/showActionMenu?value=2");

        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];

            #QUEDA PENDIENTE VER A DONDE MANDAR
            require_once(VIEWS_PATH . "/sections/guardianView.php");
        }
    }

    public function guardianSelected($idGuardian, $userGuardian, $startDate, $endDate)
    {
        session_start();
        $val = 3;
        try {
            $listGuardian = $this->guardianDAO->getAll();
            $myPets = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function reservationSelected($idReservation)
    {
        session_start();
        $val = 2;

        try {
            $reservations = $this->reservationDAO->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
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
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }

        if(!is_null($listConfirmedReservations))
            $selectConfirmed = true;

        $name = $listConfirmedReservations[0]["firstName"];
        $lastName = $listConfirmedReservations[0]["lastName"];
        $id_reservation = $listConfirmedReservations[0]["id_reservation"];

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function makePayment($cardNumber, $cardOwnerName, $expirationDate, $CVC, $idReservation)
    {
        $confirmConclude = $this->reservationDAO->concludeReserve($idReservation);

        if($confirmConclude == 1)
        {
            $confirmDeletePaymentCoupon = $this->reservationDAO->deletePaymentCoupon($idReservation);
        }

        header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=4");
    }
}