<?php

namespace Controllers;

use DAO\OwnerDAO;
use DAO\GuardianDAO;
use Exception;
use DAO\ReservationDAO as ReservationDAO;

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
            if ($val == 1 || $val == 2) {
                $petArray = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
            } elseif ($val == 3) {
                $listGuardian = $this->guardianDAO->getAll();
                $myPets = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
            } elseif ($val == 4) {
                $listConfirmedReservations = $this->reservationDAO->getConfirmedReservationsByGuardian($_SESSION["user"]->getIdOwner());
                var_dump($listConfirmedReservations);
            }
        } catch
        (Exception $e) {
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

        // $this->showActionMenu(3);
    }
}