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

    public function showTypeAccount()
    {
        require_once(VIEWS_PATH . "/sections/typeAcc.php");
    }


    public function showOwnerView()
    {
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function showGuardianView()
    {
        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function signUp($firstName, $lastName, $username, $password, $password2)
    {
        if($password === $password2)
        {
            $this->user = ["firstName"=>$firstName, "lastName"=>$lastName, "username"=>$username, "password"=>$password];
            $_SESSION['user'] = $this->user;
        }
        $this->showTypeAccount();
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
        session_destroy();
        session_start();
        $listGuardian = $this->guardianDAO->GetAll();
        $listOwner = $this->ownerDAO->GetAll();
        $flag = false;
        foreach ($listGuardian as $value)
        {
            if ($value->getUsername() === $username && $value->getPassword() === $password)
            {
                $loggedUser = $value;
                $_SESSION['loggedUser'] = $loggedUser;
                $flag = true;
                break;
            }
        }
        if (!$flag)
        {
            foreach ($listOwner as $value)
            {
                if ($value->getUsername() === $username && $value->getPassword() === $password)
                {
                    $loggedUser = $value;
                    $_SESSION['loggedUser'] = $loggedUser;

                    break;
                }
            }
        }

        if(isset($_SESSION))
        {
            if($flag){
                $this->showGuardianView();
            }
            else{
                $this->showOwnerView();
            }
        }
    }
}