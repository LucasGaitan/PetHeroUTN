<?php

namespace DAO;

use Exception;
use http\Message;
use Models\User as User;
use Models\userTemplate as UserTemplate;

class UserDAO implements IDAO
{
    private $tableName;
    private $connection;

    function __construct()
    {
        $this->tableName = 'users';
    }

    public function Add($user)
    {
        $query = "INSERT INTO " . $this->tableName . "(firstName, lastName, username, password, email) 
        VALUES (:firstName, :lastName, :username, :password, :email)";

        try
        {
            $this->connection = Connection::GetInstance();

            $parameters['firstName'] = $user->getFirstName();
            $parameters['lastName'] = $user->getLastName();
            $parameters['username'] = $user->getUserName();
            $parameters['password'] = $user->getPassword();
            $parameters['email'] = $user->getEmail();

            $this->connection->ExecuteNonQuery($query, $parameters);
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    private function mapUsers($users)
    {
        $users = is_array($users) ? $users : [];

        $resp = array_map(function($p)
        {
            $user = new UserTemplate();
            $user->setId($p["id_user"]);
            $user->setFirstName($p["firstName"]);
            $user->setLastName($p["lastName"]);
            $user->setUserName($p["username"]);
            $user->setPassword($p["password"]);
            $user->setEmail($p["email"]);

            return $user;
        }, $users);

        return count($resp) > 1 ? $resp : $resp[0];
    }

    public function getAll()
    {
        $query = "SELECT * FROM users";
        $listUser = array();

        try
        {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

            if(!empty($result))
            {
                $listUser = $this->mapUsers($result);
            }
        }
        catch(Exception $e)
        {
            throw $e;
        }

        return $listUser;
    }

    public function findUserByUsername($username)
    {
        $query = "SELECT * FROM users U WHERE U.username = :username";

        $parameters['username'] = $username;

        try
        {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $parameters);
        }
        catch(Exception $e)
        {
            throw $e;
        }

        if(!empty($result))
            return $this->mapUsers($result);
        else
            return null;
    }

    public function findMatchRole($id)
    {
        try
        {
            $this->connection = Connection::GetInstance(); #Abrimos la conexion
            $query = "SELECT O.id_user, O.id_owner FROM owners O WHERE O.id_user = :id"; #Buscamos en owner
            $parameters['id'] = $id;
            $resultOwner = $this->connection->Execute($query, $parameters);

            if(isset($resultOwner[0]['id_owner']))
                return 1; #Si el owner existe, retornamos 1
            else #Si no existe...
            {
                $query = "SELECT G.id_user, G.id_guardian FROM guardians G WHERE G.id_user = :id"; #Buscamos Guardian
                $parameters['id'] = $id;
                $resultGuardian = $this->connection->Execute($query, $parameters);
                if(isset($resultGuardian[0]['id_guardian']))
                    return 2; #Si el guardian existe, retornamos 2
                else
                    return 3; #Si no es ninguno de ambos, retornamos 3
            }
        }
        catch (Exception $e)
        {
            return 3;
        }
    }

    public function findIdByUsername($username)
    {
        $query = "SELECT U.id_user FROM users U WHERE U.username = :username";

        $parameters['username'] = $username;

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $parameters);

            return $result[0]['id_user'];
        }
        catch(Exception $e)
        {
            throw $e;
        }
    }
}