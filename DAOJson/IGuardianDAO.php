<?php

namespace DAOJson;

use Models\Guardian as Guardian;

interface IGuardianDAO
{
    function Add(Guardian $guardian);
    function GetAll();
}