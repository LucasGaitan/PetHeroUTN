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

        #findmatchrole
        #obtengo el usuario y lo guardo en sesion

        header("location: " . FRONT_ROOT . "Auth/showGuardianView");

    }

    public function ownerForm()
    {
        session_start();
        var_dump($_SESSION);
        $this->user = $_SESSION['user'];
        $id_user = $this->userDAO->findIdByUsername($this->user->getUsername());
        $this->ownerDAO->Add($id_user);

        header("location: " . FRONT_ROOT . "Auth/showOwnerView");
    }


}