<?php

namespace Controllers;

use DAO\GuardianDAO;
use DAO\ReservationDAO;
use Exception;


class GuardianController
{
    private $guardianDAO;
    //private $postulation; PARA JSON


    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        //$this->postulation = new Postulation(); PARA JSON
    }

    /*public function postulationForm($startDate, $endDate, $hoursPerDay, $description)  PARA JSON
    {
        $this->postulation->setStartDate($startDate);
        $this->postulation->setEndDate($endDate);
        $this->postulation->setHoursPerDay($hoursPerDay);
        $this->postulation->setDescription($description);
        $_SESSION['loggedUser']->setPostulation($this->postulation);
        $this->guardianDAO->Add($_SESSION['loggedUser']);
    }*/

    public function showActionMenu($value, $alert = null)
    {
        session_start();
        $val = $value;
        if ($val == 1) {
            $firstName = $_SESSION['user']->getFirstName();
            $lastName = $_SESSION['user']->getLastName();
        } elseif ($val == 2) {
            try {
                $startDate = $_SESSION['user']->getStartDate();
                $endDate = $_SESSION['user']->getEndDate();
                $reservationDAO = new ReservationDAO();
                $reservations = $reservationDAO->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());
            } catch (Exception $e) {
                $alert = [
                    "type" => "danger",
                    "text" => $e->getMessage()
                ];
            }
        }
        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function setWorkDates($startDate, $endDate)
    {
        try {
            session_start();
            if ($this->guardianDAO->updateWorkDates($_SESSION["user"]->getIdGuardian(), $startDate, $endDate) == 1) {
                $_SESSION["user"]->setStartDate($startDate);
                $_SESSION["user"]->setEndDate($endDate);
                header("location: " . FRONT_ROOT . "Guardian/showActionMenu?value=2");
            } else {
                throw new Exception("The dates could not be updated, please try again.");
            }
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            $this->showActionMenu(2, $alert);
        }
    }
}