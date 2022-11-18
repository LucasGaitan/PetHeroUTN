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

    public function __construct()
    {
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
        $this->userDAO = new userDAO();
    }

    public function guardianForm($dogTypeExpected, $salaryExpected)
    {
        try {
            session_start();
            $user = $_SESSION['user'];
            $id_user = $this->userDAO->findIdByUsername($user->getUsername());

            $guardian = new Guardian();
            $guardian->setId($id_user);
            $guardian->setId_animal_size_expected($dogTypeExpected);
            $guardian->setSalaryExpected($salaryExpected);

            if ($this->guardianDAO->Add($guardian) == 1){
                $id_guardian = $this->guardianDAO->findGuardianIdByUserId($id_user);
                $user_temp = $this->userDAO->findUserByUsername($user->getUsername());

                $guardian_temp = new Guardian();
                $guardian_temp->setId($id_user);
                $guardian_temp->setFirstName($user_temp->getFirstName());
                $guardian_temp->setLastName($user_temp->getLastName());
                $guardian_temp->setUsername($user_temp->getUsername());
                $guardian_temp->setEmail($user_temp->getEmail());
                $guardian_temp->setIdGuardian($id_guardian);
                $guardian_temp->setId_animal_size_expected($dogTypeExpected);
                $guardian_temp->setSalaryExpected($salaryExpected);

                $_SESSION["user"] = $guardian_temp;
                header("location: " . FRONT_ROOT . "Auth/showGuardianView");
            }else{
                throw new Exception("The guardian could not be added, please try again.");
            }


        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            require_once(VIEWS_PATH . "/sections/typeAcc.php");
        }
    }

    public function ownerForm()
    {
        try {
            session_start();
            $user = $_SESSION['user'];
            $id_user = $this->userDAO->findIdByUsername($user->getUsername());

            if($this->ownerDAO->Add($id_user) == 1)
            {
                $id_owner = $this->ownerDAO->findOwnerIdByUserId($id_user);
                $user_temp = $this->userDAO->findUserByUsername($user->getUsername());

                $owner_temp = new Owner();
                $owner_temp->setId($id_user);
                $owner_temp->setFirstName($user_temp->getFirstName());
                $owner_temp->setLastName($user_temp->getLastName());
                $owner_temp->setUsername($user_temp->getUsername());
                $owner_temp->setEmail($user_temp->getEmail());
                $owner_temp->setIdOwner($id_owner);

                $_SESSION["user"] = $owner_temp;
                header("location: " . FRONT_ROOT . "Auth/showOwnerView");
            }else{
                throw new Exception("The owner could not be added, please try again.");
            }


        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            require_once(VIEWS_PATH . "/sections/typeAcc.php");
        }
    }


    /*
    public function guardianForm($dogTypeExpected, $salaryExpected)  PARA JSON
    {
        $this->user = $_SESSION['user'];
        $this->user["dogTypeExpected"] = $dogTypeExpected;
        $this->user["salaryExpected"] = $salaryExpected;
        $guardian = new Guardian();
        $guardian->setFirstName($this->user['firstName']);
        $guardian->setLastName($this->user['lastName']);
        $guardian->setUsername($this->user['username']);
        $guardian->setPassword($this->user['password']);
        $guardian->setDogTypeExpected($this->user['dogTypeExpected']);
        $guardian->setSalaryExpected($this->user['salaryExpected']);
        $this->guardianDAO->Add($guardian);

    }
    public function ownerForm() PARA JSON
    {
        $this->user = $_SESSION['user'];
        $owner = new Owner();
        $owner->setFirstName($this->user['firstName']);
        $owner->setLastName($this->user['lastName']);
        $owner->setUsername($this->user['username']);
        $owner->setPassword($this->user['password']);
        $this->ownerDAO->Add($owner);
    }
*/
}