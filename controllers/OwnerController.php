<?php

namespace Controllers;

use DAO\OwnerDAO;
use DAO\GuardianDAO;
use Models\Owner;
use Models\Reservation as Reservation;

class OwnerController
{
    private $ownerDAO;
    private $guardianDAO;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->guardianDAO = new GuardianDAO();
    }

//    public function showDogList(){
//
//        require_once(VIEWS_PATH . "/sections/animalList.php");
//    }

    public function showActionMenu($value){

        session_start();
        $val = 0;
        $val = $value;

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function FilterDates($startDate, $endDate)
    {
        $guardiansFiltered = $this->guardianDAO->getGuardiansFilterByDates($startDate, $endDate);
        $val = 3;

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }


}