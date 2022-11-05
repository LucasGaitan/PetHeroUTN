<?php

namespace Controllers;

use DAO\GuardianDAO;
use DAO\OwnerDAO;
use DAO\UserDAO;
use Exception;
use Models\Owner;

class AuthController
{
    private $userDAO;
    private $user;

    public function __construct()
    {
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
        $this->userDAO = new userDAO();
        $this->user = array();
    }

    public function index($message =""){
        require_once(VIEWS_PATH. "index.php");
    }

    public function signUp($firstName, $lastName, $username, $password, $password2, $email)
    {
        if($password === $password2)
        {
            $this->user = ["username"=>$username, "email"=>$email];

            $this->userDAO->Add($firstName, $lastName, $username, $password, $email);
            session_start();
            $_SESSION['user'] = $this->user;
            $this->showTypeAccount();
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
                    //    return header('location:' . VIEWS_PATH . 'sections/ownerView.php');
                        $owner = new Owner();
                        $owner->setIdOwner($this->ownerDAO->findOwnerIdByUserId($_SESSION['user']->getId()));
                        $owner->setFirstName($_SESSION['user']->getFirstName());
                        $owner->setLastName($_SESSION['user']->getLastName());
                        $owner->setUserName($_SESSION['user']->getUsername());
                        $owner->setEmail($_SESSION['user']->getFirstName());
                        $_SESSION['user'] = $owner;
                        $this->showOwnerView();
// //                         $this->views($redirectionView);
                        break;

                    case 2:
//                        header('location:' . VIEWS_PATH . 'sections/guardianView.php');
                        $this->showGuardianView();
//                            $this->views($redirectionView);
                        break;

                    case 3:
                        $this->showTypeAccount();
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

    public function showLandPage(){
        return header("location: " . FRONT_ROOT . "index.php");
    }
}