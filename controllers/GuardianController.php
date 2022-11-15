<?php

namespace Controllers;

use Controllers\ReservationController as ReservationController;
use DAO\GuardianDAO;
use DAO\ReservationDAO;
use Exception;

//use Models\Postulation;

class GuardianController
{
    private $guardianDAO;
//    private $postulation;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
//      $this->postulation = new Postulation();
    }
//
//    public function postulationForm($startDate, $endDate, $hoursPerDay, $description)
//    {
//        $this->postulation->setStartDate($startDate);
//        $this->postulation->setEndDate($endDate);
//        $this->postulation->setHoursPerDay($hoursPerDay);
//        $this->postulation->setDescription($description);
//        $_SESSION['loggedUser']->setPostulation($this->postulation);
//        $this->guardianDAO->Add($_SESSION['loggedUser']);
//    }

    public function showActionMenu($value)
    {
        session_start();
        $val = $value;

        if ($val == 2) {
            try {
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
        session_start();
        try {
            $this->guardianDAO->updateWorkDates($_SESSION["user"]->getIdGuardian(), $startDate, $endDate);
            $_SESSION["user"]->setStartDate($startDate);
            $_SESSION["user"]->setEndDate($endDate);
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        header("location: " . FRONT_ROOT . "Guardian/showActionMenu?value=2");
        //$this->showActionMenu(2); REVISAR
    }
}