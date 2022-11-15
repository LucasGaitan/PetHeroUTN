<?php

namespace Controllers;
use DAO\GuardianDAO;
use DAO\OwnerDAO;
use Exception;
use Models\reservation;
use DAO\ReservationDAO;

class ReservationController
{
    private $reservationDAO;
    private $guardianDAO;
    private $ownerDAO;

    public function __construct()
    {
        $this->reservationDAO = new ReservationDAO();
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
    }

    // SHOWS FOR ALERTS
    public function showGuardianListAlert($alert)
    {
        try {
        $listGuardian = $this->guardianDAO->getAll();
            $myPets = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val = 3;
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function showReservationListAlert($alert)
    {
        try {
            $startDate = $_SESSION['user']->getStartDate();
            $endDate = $_SESSION['user']->getEndDate();
            $reservations = $this->reservationDAO->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val=2;
        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function showConfirmedReservationsAlert($alert)
    {
        try {
            $listConfirmedReservations = $this->reservationDAO->getConfirmedReservationsByGuardian($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val=4;
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    //FORM
    public function ReservationForm($startDate, $endDate, $id_animal, $idGuardian)
    {
        $startDate2 = strtotime($startDate);
        $endDate2 = strtotime($endDate);

        if ($startDate2 <= $endDate2) {
            $reservation = new reservation();
            $reservation->setIdGuardian($idGuardian);
            $reservation->setStartDate($startDate);
            $reservation->setEndDate($endDate);
            $reservation->setState(0);
            $reservation->setConcluded(0);

            $reservation_animals = ["reservation" => $reservation, "id_animal" => $id_animal];
            try {
                $this->reservationDAO->add($reservation_animals);
                header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=3");
            } catch (Exception $e) {
                $alert = [
                    "type" => "danger",
                    "text" => $e->getMessage()
                ];
                $this->ownerController->showActionMenu(3);
                //require_once(VIEWS_PATH . "/sections/ownerView.php");
            }
        } else {
            $alert = [
                "type" => "danger",
                "text" => "The end date cannot exceed the start date."
            ];
            $this->showGuardianListAlert($alert);
        }

    }


    //FUNCTIONS FOR SELECT IN VIEW
    public function guardianSelected($idGuardian, $userGuardian, $startDate, $endDate)
    {
        session_start();

        try {
            $listGuardian = $this->guardianDAO->getAll();
            $myPets = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val = 3;
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function reservationSelected($idReservation)
    {
        session_start();
        try {
            $reservations = $this->reservationDAO->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());
            $startDate = $_SESSION['user']->getStartDate();
            $endDate = $_SESSION['user']->getEndDate();
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val = 2;
        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function confirmedReservationSelected($idGuardian)
    {
        session_start();

        try {
            $listConfirmedReservations = $this->reservationDAO->getConfirmedReservationsByGuardian($_SESSION["user"]->getIdOwner());
            if (!is_null($listConfirmedReservations))
                $selectConfirmed = true;

            $name = $listConfirmedReservations[0]["firstName"];
            $lastName = $listConfirmedReservations[0]["lastName"];
            $id_reservation = $listConfirmedReservations[0]["id_reservation"];
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val = 4;
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }


    //RESERVATION STATES FUNCTIONS
    public function ConfirmReservation($idReservation)
    {
        session_start();

        try {
            $confirmed = $this->reservationDAO->updateState($idReservation);

            if ($confirmed == 1) {
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
            $this->showReservationListAlert($alert);
        }
    }


    public function makePayment($cardNumber, $cardOwnerName, $expirationDate, $CVC, $idReservation)
    {
        try {
            $confirmConclude = $this->reservationDAO->concludeReserve($idReservation);
            if ($confirmConclude == 1) {
                $confirmDeletePaymentCoupon = $this->reservationDAO->deletePaymentCoupon($idReservation);
            }
            header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=4");
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            $this->showConfirmedReservationsAlert($alert);
        }
    }
}