<?php
    namespace DAOJson;

    use Models\Owner as Owner;

    interface IOwnerDAO
    {
        function Add(Owner $owner);
        function GetAll();
    }