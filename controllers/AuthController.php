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
    private $user;

    public function __construct()
    {
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
        $this->userDAO = new userDAO();
        $this->user = new userTemplate();
    }

    public function index($message =""){
        require_once(VIEWS_PATH. "index.php");
    }

    public function signUp($firstName, $lastName, $username, $password, $password2, $email)
    {
        if($password === $password2)
        {
            $this->user->setUsername($username);
            $this->user->setPassword($password);

            $user = new userTemplate();
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setEmail($email);
            try {
                $this->userDAO->Add($user);
            } catch (Exception $e) {
                echo $e->getMessage();
            }
            session_start();
            $_SESSION['user'] = $this->user;
            header("location: " . FRONT_ROOT . "Auth/showTypeAccount");
        }
        else
        {
            #SE ENTIENDE
        }
    }

    public function signIn($username, $password)
    {
        $user = $this->userDAO->findUserByUsername($username);
        session_start();
        $_SESSION['user'] = $user;

        try {
            if(isset($user) && $user->getPassword() === $password)
            {
                $id = $user->getId();
                #Si es owner o guardian
                $redirectionView = $this->userDAO->findMatchRole($id);
                switch($redirectionView)
                {
                    case 1:
                        $owner = new Owner();
                        $owner->setIdOwner($this->ownerDAO->findOwnerIdByUserId($_SESSION['user']->getId()));
                        $owner->setFirstName($_SESSION['user']->getFirstName());
                        $owner->setLastName($_SESSION['user']->getLastName());
                        $owner->setUserName($_SESSION['user']->getUsername());
                        $owner->setEmail($_SESSION['user']->getFirstName());
                        $_SESSION['user'] = $owner;
                        header("location: " . FRONT_ROOT . "Auth/showOwnerView");
                        break;

                    case 2:
                        $guardian = new Guardian();
                        $guardian->setIdGuardian($this->guardianDAO->findGuardianIdByUserId($_SESSION['user']->getId()));
                        $guardian->setFirstName($_SESSION['user']->getFirstName());
                        $guardian->setLastName($_SESSION['user']->getLastName());
                        $guardian->setUserName($_SESSION['user']->getUsername());
                        $guardian->setEmail($_SESSION['user']->getFirstName());

                        $dates = $this->guardianDAO->bringStartAndEndDates($guardian->getIdGuardian());

                        $guardian->setStartDate($dates[0]['startDate']);
                        $guardian->setEndDate($dates[0]['endDate']);
                        $_SESSION['user'] = $guardian;
                        header("location: " . FRONT_ROOT . "Auth/showGuardianView");
                        break;

                    case 3:
                        header("location: " . FRONT_ROOT . "Auth/showTypeAccount");
                        break;
                }
            }
            else
            {
                #Mensaje de fallo de inicio de sesion
                echo 'Incorrect username or password, please try again.';
            }
        }catch(Exception $e)
        {
            echo $e;
        }

//        session_start();
//        $listGuardian = $this->guardianDAO->GetAll();
//        $listOwner = $this->ownerDAO->GetAll();
//        $flag = false;
//        foreach ($listGuardian as $value)
//        {
//            if ($value->getUsername() === $username && $value->getPassword() === $password)
//            {
//                $loggedUser = $value;
//                $_SESSION['loggedUser'] = $loggedUser;
//                $flag = true;
//                break;
//            }
//        }
//        if (!$flag)
//        {
//            foreach ($listOwner as $value)
//            {
//                if ($value->getUsername() === $username && $value->getPassword() === $password)
//                {
//                    $loggedUser = $value;
//                    $_SESSION['loggedUser'] = $loggedUser;
//
//                    break;
//                }
//            }
//        }
//
//        if(isset($_SESSION))
//        {
//            if($flag){
//                $this->showGuardianView();
//            }
//            else{
//                $this->showOwnerView();
//            }
//        }


    }

    public function logOut(){
            
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
        require_once(VIEWS_PATH . "/sections/ownerView.php");
    }

    public function showGuardianView()
    {
        session_start();
        require_once(VIEWS_PATH . "/sections/guardianView.php");
    }

    public function showLandPage(){
        header("location: " . FRONT_ROOT . "index.php");
    }
}