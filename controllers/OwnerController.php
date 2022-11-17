<?php

namespace Controllers;

use DAO\AnimalDAO;
use DAO\OwnerDAO;
use DAO\GuardianDAO;
use Exception;
use DAO\ReservationDAO;

class OwnerController
{
    private $ownerDAO;
    private $guardianDAO;
    private $reservationDAO;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->guardianDAO = new GuardianDAO();
        $this->reservationDAO = new ReservationDAO();
    }


    public function showActionMenu($value)
    {
        session_start();
        $val = $value;
        try {
            $animalDAO = new AnimalDAO(); //Para animal form como es modal hay que hacerlo en owner view
            $animalBreeds = $animalDAO->getTypesBreeds(); //Para animal form como es modal hay que hacerlo en owner view
            $animalSizes = $animalDAO->getAllSizes(); //Para animal form como es modal hay que hacerlo en owner view
            if ($val == 1) {
                $petArray = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
                $firstName = $_SESSION['user']->getFirstName();
                $lastName = $_SESSION['user']->getLastName();
            } elseif ($val == 2) {
                $petArray = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
            } elseif ($val == 3) {
                $listGuardian = $this->guardianDAO->getAll();
                $myPets = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
            } elseif ($val == 4) {
                $listConfirmedReservations = $this->reservationDAO->getConfirmedReservationsByGuardian($_SESSION["user"]->getIdOwner());
            } elseif ($val == 5) {
                $listConfirmedReservationsForConcluded = $this->reservationDAO->getConfirmedReservationsByGuardianForConcluded($_SESSION["user"]->getIdOwner());
            }

        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function FilterDates($startDate, $endDate)
    {
        try {
            $guardiansFiltered = $this->guardianDAO->getGuardiansFilterByDates($startDate, $endDate);
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        $val = 3;
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }
}