<?php

namespace Controllers;

use DAO\OwnerDAO;
use Models\Owner;

class OwnerController
{
    private $ownerDAO;

    public function __construct()
    {
        $this->ownerDAO = new OwnerDAO();
    }

    public function showDogList(){
        
        require_once(VIEWS_PATH . "/sections/dogList.php");
    }

    public function showActionMenu($value){

        session_start();
        
        $val = 0;

        $val = $value;

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }
}