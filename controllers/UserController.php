<?php


namespace Controllers;

use DAO\GuardianDAO;
use DAO\OwnerDAO;
use Models\Guardian;
use Models\Owner;

class UserController
{
    private $guardianDAO;
    private $ownerDAO;
    private $user;


    public function __construct()
    {
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
        $this->user = array();
    }

    public function ShowTypeAccount()
    {
        require_once(VIEWS_PATH . "/sections/typeAcc.php");
    }

    public function signUp($firstName, $lastName, $username, $password, $password2)
    {
        if($password === $password2)
        {
            $this->user = ["firstName"=>$firstName, "lastName"=>$lastName, "username"=>$username, "password"=>$password];
            $_SESSION['user'] = $this->user;
        }
        $this->ShowTypeAccount();
    }

    public function guardianForm($dogTypeExpected, $salaryExpected)
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
    public function ownerForm()
    {
        $this->user = $_SESSION['user'];
        $owner = new Owner();
        $owner->setFirstName($this->user['firstName']);
        $owner->setLastName($this->user['lastName']);
        $owner->setUsername($this->user['username']);
        $owner->setPassword($this->user['password']);
        $this->ownerDAO->Add($owner);
    }

    public function signIn($username, $password)
    {
        $listGuardian = $this->guardianDAO->GetAll();
        $listOwner = $this->ownerDAO->GetAll();



        /*for ($i = 0; $i<count($listGuardian);$i++ )
        {
            if ($listGuardian['username'] = $username)
            {
                echo $listGuardian['username'];
            }
        }*/
        echo "<pre>";
        var_dump($listGuardian);
        echo "</pre>";
        echo "<pre>";
        var_dump($listOwner);
        echo "</pre>";
    }
}