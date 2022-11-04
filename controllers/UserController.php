<?php

namespace Controllers;

use DAO\GuardianDAO;
use DAO\OwnerDAO;
use DAO\UserDAO;
use Exception;
use Models\Guardian;
use Models\Owner;

class UserController
{
    private $guardianDAO;
    private $ownerDAO;
    private $userDAO;
    private $user;

    public function __construct()
    {
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
        $this->userDAO = new userDAO();
        $this->user = array();
    }

    public function showOwnerView()
    {
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function guardianForm($dogTypeExpected, $salaryExpected)
    {
        session_start();
        $this->user = $_SESSION['user'];
        $id_user = $this->userDAO->findIdByUsername($this->user->getUsername());
        $guardian = new Guardian();
        $guardian->setId($id_user);
        $guardian->setId_animal_size_expected($dogTypeExpected);
        $guardian->setSalaryExpected($salaryExpected);
        $this->guardianDAO->Add($guardian);
    }

    public function ownerForm()
    {
        session_start();
        $this->user = $_SESSION['user'];
        $id_user = $this->userDAO->findIdByUsername($this->user->getUsername());
        $this->ownerDAO->Add($id_user);
        $this->showOwnerView();
    }


}