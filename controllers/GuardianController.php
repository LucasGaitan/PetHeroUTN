<?php

namespace Controllers;

use DAO\GuardianDAO;
use Models\Postulation;

class GuardianController
{
    private $guardianDAO;
    private $postulation;

    public function __construct()
    {
        $this->guardianDAO = new GuardianDAO();
        $this->postulation = new Postulation();
    }

    public function postulationForm($startDate, $endDate, $hoursPerDay, $description)
    {
        $this->postulation->setStartDate($startDate);
        $this->postulation->setEndDate($endDate);
        $this->postulation->setHoursPerDay($hoursPerDay);
        $this->postulation->setDescription($description);
        $_SESSION['loggedUser']->setPostulation($this->postulation);
        $this->guardianDAO->Add($_SESSION['loggedUser']);
    }

    public function showActionMenu($value){

        session_start();
        
        $val = 0;

        $val = $value;

        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }
}