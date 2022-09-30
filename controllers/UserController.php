<?php

namespace Controllers;

use DAO\GuardianDAO;
use DAO\OwnerDAO;

class UserController
{
    private $guardianDAO;
    private $ownerDAO;


    public function __construct()
    {
        $this->guardianDAO = new guardianDAO();
        $this->ownerDAO = new ownerDAO();
    }


    public function ShowAddView()
    {
        require_once(VIEWS_PATH . "user-add.php");
    }

    public function ShowListView()
    {
        //$userList = $this->userDAO->GetAll();

        require_once(VIEWS_PATH . "user-list.php");
    }

    public function signUp($firstName, $lastName, $username, $password, $password2)
    {
        if($password === $password2)
        {
            $user = (object) ["firstName"=>$firstName, "lastName"=>$lastName, "username"=>$username, "password"=>$password];
            var_dump($user);
        }
    }
}