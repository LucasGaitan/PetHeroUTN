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
        $this->showOwnerView

        ();
    }
//
//    public function views($redirectionView)
//    {
//        if($redirectionView == 1)
//            $this->showOwnerView();
//        else
//            $this->showGuardianView();
//    }

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
//                        header('location:' . VIEWS_PATH . 'sections/ownerView.php');
                        $this->showOwnerView();
//                         $this->views($redirectionView);
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
}