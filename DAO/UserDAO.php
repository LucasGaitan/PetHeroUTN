<?php

namespace DAO;

use Exception;
use Models\userTemplate as UserTemplate;

class UserDAO implements IDAO
{
    private $tableName;
    private $connection;

    function __construct()
    {
        $this->tableName = 'users';
    }

    /**
     * ADD
     */

    public function Add($user)
    {
        $query = "INSERT INTO " . $this->tableName . "(firstName, lastName, username, password, email) 
        VALUES (:firstName, :lastName, :username, :password, :email)";

        try {
            $this->connection = Connection::GetInstance();

            $parameters['firstName'] = $user->getFirstName();
            $parameters['lastName'] = $user->getLastName();
            $parameters['username'] = $user->getUserName();
            $parameters['password'] = $user->getPassword();
            $parameters['email'] = $user->getEmail();

            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * GETS
     */

    public function findUserByUsername($username)
    {
        $query = "SELECT * FROM users U WHERE U.username = :username";

        $parameters['username'] = $username;

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $this->mapUsers($result);
            }

        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

    public function findMatchRole($id)
    {
        try {
            $this->connection = Connection::GetInstance();
            $query = "SELECT o.id_owner, g.id_guardian FROM users u
                        LEFT JOIN guardians g ON u.id_user = g.id_user
                        LEFT JOIN owners o ON u.id_user = o.id_user
                      WHERE u.id_user = :id";
            $parameters['id'] = $id;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $this->mapMatchRole($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }


    public function findIdByUsername($username)
    {
        $query = "SELECT U.id_user FROM users U WHERE U.username = :username";

        $parameters['username'] = $username;

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $result[0]['id_user'];
            }

        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     * MAPS
     */

    private function mapUsers($users)
    {
        $resp = array_map(function ($p) {
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


    private function mapMatchRole($result)
    {
        $resp = array_map(function ($p) {
            return ["id_owner" => $p["id_owner"], "id_guardian" => $p["id_guardian"]];
        }, $result);
        return count($resp) > 1 ? $resp : $resp[0];
    }

}