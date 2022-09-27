<?php

namespace Models;

use Models\User as User;
use parent;

class Owner extends User{
    private $dogs;

    function __construct()
    {
        parent::__construct();
        $this->dogs = array();
    }
    
}