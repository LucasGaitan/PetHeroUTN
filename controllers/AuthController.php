<?php

namespace Controllers;

use DAO\AnimalDAO;
use DAO\GuardianDAO;
use DAO\OwnerDAO;
use DAO\UserDAO;
use Exception;
use Models\Guardian;
use Models\Owner;
use Models\userTemplate;

class AuthController
{
    private $userDAO;
    private $guardianDAO;
    private $ownerDAO;

    public function __construct()
    {
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
        $this->userDAO = new userDAO();
    }

    public function index($message = "")
    {
        require_once(VIEWS_PATH . "index.php");
    }

    public function signUp($firstName, $lastName, $username, $password, $password2, $email)
    {
        if ($password === $password2) {
            $user = new userTemplate();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            try {
                if ($this->userDAO->Add($user) == 1) {
                    session_start();
                    $_SESSION['user'] = $user;
                    header("location: " . FRONT_ROOT . "Auth/showTypeAccount");
                } else {
                    throw new Exception("The user could not be added, please try again");
                }

            } catch (Exception $e) {
                $alert = [
                    "type" => "danger",
                    "text" => $e->getMessage()
                ];
                require_once(VIEWS_PATH . "index.php");
            }
        } else {
            $alert = [
                "type" => "warning",
                "text" => "Passwords don't match."
            ];
            require_once(VIEWS_PATH . "index.php");
        }
    }

    public function signIn($username, $password)
    {
        try {
            session_start();
            $user = $this->userDAO->findUserByUsername($username);
            if (isset($user) && $user->getPassword() === $password) {
                $id = $user->getId();
                #Si es owner o guardian
                $redirectionView = $this->userDAO->findMatchRole($id);
                if (!is_null($redirectionView["id_owner"])) { # Si es Owner
                    $owner = new Owner();
                    $owner->setIdOwner($this->ownerDAO->findOwnerIdByUserId($user->getId()));
                    $owner->setFirstName($user->getFirstName());
                    $owner->setLastName($user->getLastName());
                    $owner->setUserName($user->getUsername());
                    $owner->setEmail($user->getFirstName());
                    $_SESSION['user'] = $owner;

                    header("location: " . FRONT_ROOT . "Auth/showOwnerView");
                } elseif (!is_null($redirectionView["id_guardian"])) { # Si es Guardian
                    $guardian = new Guardian();
                    $guardian->setIdGuardian($this->guardianDAO->findGuardianIdByUserId($user->getId()));
                    $guardian->setFirstName($user->getFirstName());
                    $guardian->setId_animal_size_expected($this->guardianDAO->getAnimalSizeExpectedById($guardian->getIdGuardian()));
                    $guardian->setLastName($user->getLastName());
                    $guardian->setUserName($user->getUsername());
                    $guardian->setEmail($user->getFirstName());
                    $dates = $this->guardianDAO->bringStartAndEndDates($guardian->getIdGuardian());
                    $guardian->setStartDate($dates['startDate']);
                    $guardian->setEndDate($dates['endDate']);
                    $_SESSION['user'] = $guardian;

                    header("location: " . FRONT_ROOT . "Auth/showGuardianView");
                } else { # Si no es ni owner ni guardian
                    $_SESSION['user'] = $user;

                    header("location: " . FRONT_ROOT . "Auth/showTypeAccount");
                }
            } else {
                throw new Exception("Incorrect username or password, please try again.");
            }
        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
            require_once(VIEWS_PATH . "index.php");
        }
    }


    /**
     * SHOWS
     */

    public function logOut()
    {
        session_destroy();
        header("location: " . FRONT_ROOT . "index.php");
    }

    public function showTypeAccount()
    {
        session_start();
        require_once(VIEWS_PATH . "/sections/typeAcc.php");
    }

    public function showOwnerView()
    {
        session_start();
        try {
            $animalDAO = new AnimalDAO(); //Para animal form como es modal hay que hacerlo en owner view
            $animalBreeds = $animalDAO->getTypesBreeds(); //Para animal form como es modal hay que hacerlo en owner view
            $animalSizes = $animalDAO->getAllSizes(); //Para animal form como es modal hay que hacerlo en owner view

            $petArray = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
            $firstName = $_SESSION['user']->getFirstName();
            $lastName = $_SESSION['user']->getLastName();

        } catch (Exception $e) {
            $alert = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function showGuardianView()
    {
        session_start();

        $firstName = $_SESSION['user']->getFirstName();
        $lastName = $_SESSION['user']->getLastName();

        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    /*public function signUp($firstName, $lastName, $username, $password, $password2) PARA JSON
    {
        if($password === $password2)
        {
            $this->user = ["firstName"=>$firstName, "lastName"=>$lastName, "username"=>$username, "password"=>$password];
            $_SESSION['user'] = $this->user;
        }
       $this->showTypeAccount();
        }

    public function signIn($username, $password) PARA JSON
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
    }*/
}