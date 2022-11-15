<?php

namespace Controllers;

use DAO\GuardianDAO;
use DAO\OwnerDAO;
use DAO\UserDAO;
use Exception;
use Models\Guardian;
use Models\Owner;
use Models\userTemplate;
use Controllers\OwnerController;

class AuthController
{
    private $userDAO;

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
                $this->userDAO->Add($user);
                session_start();
                $_SESSION['user'] = $user;
                header("location: " . FRONT_ROOT . "Auth/showTypeAccount");
            } catch (Exception $e) {
                #MANDAR ALERT
                $alert = [
                    "type" => "warning",
                    "text" => $e->getMessage()
                ];
                require_once(VIEWS_PATH . "index.php");
            }
        } else {
            #MANDAR ALERT
        }
    }

    public function signIn($username, $password)
    {
        $user = $this->userDAO->findUserByUsername($username);
        session_start();
        try {
            if (isset($user) && $user->getPassword() === $password) {
                $id = $user->getId();
                #Si es owner o guardian
                $redirectionView = $this->userDAO->findMatchRole($id);
                if (!is_null($redirectionView[0]["id_owner"])) {
                    $owner = new Owner();
                    $owner->setIdOwner($this->ownerDAO->findOwnerIdByUserId($user->getId()));
                    $owner->setFirstName($user->getFirstName());
                    $owner->setLastName($user->getLastName());
                    $owner->setUserName($user->getUsername());
                    $owner->setEmail($user->getFirstName());
                    $_SESSION['user'] = $owner;
                    header("location: " . FRONT_ROOT . "Auth/showOwnerView");
                } elseif (!is_null($redirectionView[0]["id_guardian"])) {
                    $guardian = new Guardian();
                    $guardian->setIdGuardian($this->guardianDAO->findGuardianIdByUserId($user->getId()));
                    $guardian->setFirstName($user->getFirstName());
                    $guardian->setLastName($user->getLastName());
                    $guardian->setUserName($user->getUsername());
                    $guardian->setEmail($user->getFirstName());
                    $dates = $this->guardianDAO->bringStartAndEndDates($guardian->getIdGuardian());
                    $guardian->setStartDate($dates[0]['startDate']);
                    $guardian->setEndDate($dates[0]['endDate']);
                    $_SESSION['user'] = $guardian;
                    header("location: " . FRONT_ROOT . "Auth/showGuardianView");
                } else {
                    $_SESSION['user'] = $user;
                    header("location: " . FRONT_ROOT . "Auth/showTypeAccount");
                }
            } else {
                #Mensaje de fallo de inicio de sesion
                #MANDAR ALERT
                echo 'Incorrect username or password, please try again.';
            }
        } catch (Exception $e) {
            #MANDAR ALERT
            echo $e;
        }
    }

    public function logOut()
    {

        session_destroy();
        $this->showLandPage();
    }

    public function showTypeAccount()
    {
        session_start();
        require_once(VIEWS_PATH . "/sections/typeAcc.php");
    }

    public function showOwnerView()
    {
        session_start();
        $ownerController = new OwnerController();
        $petArray = $ownerController->getPetsByOwnerId();

        $firstName = $_SESSION['user']->getFirstName();
        $lastName = $_SESSION['user']->getLastName();

        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function showGuardianView()
    {
        session_start();

        $firstName = $_SESSION['user']->getFirstName();
        $lastName = $_SESSION['user']->getLastName();

        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function showLandPage()
    {
        header("location: " . FRONT_ROOT . "index.php");
    }
}