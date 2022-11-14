<?php

namespace Controllers;

use Controllers\ReservationController as ReservationController;
use DAO\GuardianDAO;
use DAO\ReservationDAO;

//use Models\Postulation;

class GuardianController
{
    private $guardianDAO;
    private $reservation;
//    private $postulation;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        $this->reservation = new ReservationDAO();
//        $this->postulation = new Postulation();
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

    public function showActionMenu($value){

        session_start();
        $val = $value;

        if ($val == 2)
        {
            $reservationController = new ReservationController();
            $reservations = $this->reservation->getReservationsByGuardianId($_SESSION["user"]->getIdGuardian());
        }
        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function getAllGuardians(){
        return $this->guardianDAO->getAll();
    }

    public function setWorkDates($startDate, $endDate)
    {
        session_start();
        $this->guardianDAO->updateWorkDates($_SESSION["user"]->getIdGuardian(), $startDate, $endDate);
        $_SESSION["user"]->setStartDate($startDate);
        $_SESSION["user"]->setEndDate($endDate);

        header("location: " . FRONT_ROOT . "Guardian/showActionMenu?value=2");
        /*$val = 2;
        require_once(VIEWS_PATH . "/sections/guardianView.php");*/
    }
}