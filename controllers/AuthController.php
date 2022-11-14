<?php

namespace Controllers;

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
                $this->userDAO->Add($user);
                session_start();
                $_SESSION['user'] = $user;
                header("location: " . FRONT_ROOT . "Auth/showTypeAccount");
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
                if (!is_null($redirectionView[0]["id_owner"])) { # Si es Owner
                    $owner = new Owner();
                    $owner->setIdOwner($this->ownerDAO->findOwnerIdByUserId($user->getId()));
                    $owner->setFirstName($user->getFirstName());
                    $owner->setLastName($user->getLastName());
                    $owner->setUserName($user->getUsername());
                    $owner->setEmail($user->getFirstName());
                    $_SESSION['user'] = $owner;
                    header("location: " . FRONT_ROOT . "Auth/showOwnerView");
                } elseif (!is_null($redirectionView[0]["id_guardian"])) { # Si es Guardian
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
        try {
            $petArray = $this->ownerDAO->getPets($_SESSION["user"]->getIdOwner());
        } catch (Exception $e) {
            $alertAuth = [
                "type" => "danger",
                "text" => $e->getMessage()
            ];
        }
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function showGuardianView()
    {
        session_start();
        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function showLandPage()
    {
        header("location: " . FRONT_ROOT . "index.php");
    }
}