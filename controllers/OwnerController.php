<?php

namespace Controllers;

use DAO\OwnerDAO;
use DAO\GuardianDAO;
use Exception;
use Controllers\GuardianController;
use DAO\AnimalDAO as AnimalDAO;

class OwnerController
{
    private $ownerDAO;
    private $guardianDAO;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
        $this->guardianDAO = new GuardianDAO();
    }


    public function showActionMenu($value){

        session_start();
        $val = $value;

        if ($val == 1 || $val == 2)
        {
            $petArray = $this->getPetsByOwnerId();
        }elseif ($val == 3)
        {
            $guardianController = new GuardianController();

            $listGuardian = $guardianController->getAllGuardians();
        }

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function FilterDates($startDate, $endDate)
    {
        $guardiansFiltered = $this->guardianDAO->getGuardiansFilterByDates($startDate, $endDate);
        $val = 3;

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function getPetsByOwnerId ()
    {
        try {
            return $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }


}