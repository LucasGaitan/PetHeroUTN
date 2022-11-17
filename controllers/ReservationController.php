<?php

namespace Controllers;

use DAO\AnimalDAO;
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
    private $animalDAO;

    public function __construct()
    {
        $this->reservationDAO = new ReservationDAO();
        $this->guardianDAO = new GuardianDAO();
        $this->ownerDAO = new OwnerDAO();
        $this->animalDAO = new AnimalDAO();
    }

    // SHOWS FOR ALERTS
    public function showGuardianListAlert($alert)
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
        $val = 2;
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
        $val = 4;
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
                if ($this->reservationDAO->Add($reservation_animals) == 1) {
                    header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=3");
                } else {
                    throw new Exception("The reservation could not be added, please try again.");
                }
            } catch (Exception $e) {
                $alert = [
                    "type" => "danger",
                    "text" => $e->getMessage()
                ];
                $this->showGuardianListAlert($alert);
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

    public function confirmedReservationSelected($idReservation)
    {

        session_start();
        try {
            $listConfirmedReservations = $this->reservationDAO->getConfirmedReservationsByGuardian($_SESSION["user"]->getIdOwner());
            if (!is_null($listConfirmedReservations)) {
                $selectConfirmed = true;
                $name = $listConfirmedReservations[0]["firstName"];
                $lastName = $listConfirmedReservations[0]["lastName"];
                $id_reservation = $listConfirmedReservations[0]["id_reservation"];
            }

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
        try {
            session_start();
            $reservationSelected = $this->reservationDAO->getReservationById($idReservation);
            $reservationSelected = $reservationSelected[0]; //Para mayor comodidad a la hora de acceder a las key

            if ($reservationSelected["animalSize"] != $this->animalDAO->getSizeById($_SESSION["user"]->getId_animal_size_expected())) { //Valido el tamaño del animal con el esperado del guardian
                throw new Exception("The size of the animal does not match the size chosen at the time of creating the profile.");
            }

            $reservationList = $this->reservationDAO->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());

            foreach ($reservationList as $value) {
                if ($reservationSelected["id_reservation"] != $value["id_reservation"] && $value["reservationState"] == 1) { // Valido que no sea la misma reserva, y que la otra reserva a validar este en estado 1 (aceptada)
                    if ($reservationSelected["animalType"] != $value["animalType"] && $reservationSelected["startDate"] >= $value["startDate"] && $reservationSelected["endDate"] <= $value["endDate"]) { //Valido el tipo del animal porque no puede aceptar reservas de distintos tipos de animales en la misma fecha
                        throw new Exception("Different types of animals are not allowed in the same date range.");
                    } elseif ($reservationSelected["animalBreed"] != $value["animalBreed"] && $reservationSelected["startDate"] >= $value["startDate"] && $reservationSelected["endDate"] <= $value["endDate"]) {//Valido la raza del animal porque no puede aceptar reservas de distintas razas de animales en la misma fecha
                        throw new Exception("Different breeds are not allowed in the same date range.");
                    }
                }
            }

            if ($this->reservationDAO->updateState($idReservation) == 1) {
                $infoCoupon = $this->guardianDAO->bringSalaryExpected($_SESSION["user"]->getIdGuardian(), $idReservation);

                $salaryExpected = $infoCoupon["salaryExpected"];
                $startDate = strtotime($infoCoupon["startDate"]);
                $endDate = strtotime($infoCoupon["endDate"]);
                $secondsPerDay = 86400;
                $numberOfSecondsRangeDate = ($endDate - $startDate);
                $numberOfDaysWorked = ($numberOfSecondsRangeDate / $secondsPerDay);

                $total = ($numberOfDaysWorked * $salaryExpected);

                if ($this->reservationDAO->createCoupon($idReservation, $total) == 1) {
                    header("location: " . FRONT_ROOT . "Guardian/showActionMenu?value=2");
                } else {
                    throw new Exception("The reservation could not be confirmed, please try again.");
                }
            } else {
                throw new Exception("The reservation could not be confirmed, please try again.");
            }

        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            $this->showReservationListAlert($alert);
        }
    }

    public function makePayment($idReservation)
    {
        try {
            session_start();

            if ($this->reservationDAO->concludeReserve($idReservation) == 1) {
                if ($this->reservationDAO->finishedReserved($idReservation) == 1) {
                    header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=4");
                } else {
                    throw new Exception("The reservation could not be paid, please try again.");
                }
            } else {
                throw new Exception("The reservation could not be paid, please try again.");
            }

        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            $this->showConfirmedReservationsAlert($alert);
        }
    }

    /* Seleccionamos la reserva a concluir */
    public function selectForConcludeReservation($idReservation)
    {
        session_start();
        try {

            $listConfirmedReservationsForConcluded = $this->reservationDAO->getConfirmedReservationsByGuardianForConcluded($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val = 5;
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    /* Concluimos la reserva, eliminando el cupon y seteando el id_coupon de la reserva en NULL con un SP */
    public function concludedReservation($stars, $idReservation)
    {
        try {
            session_start();

            $idGuardian = $this->reservationDAO->getGuardianIdByReservation($idReservation);
            if ($this->reservationDAO->finishedReservedForReview($stars, $_SESSION["user"]->getIdOwner(), $idGuardian) == 1) {
                header("location: " . FRONT_ROOT . "Owner/showActionMenu?value=5");
            } else {
                throw new Exception("The reservation could not be completed, please try again.");
            }
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            $this->showConfirmedReservationsAlert($alert);
        }
    }
}