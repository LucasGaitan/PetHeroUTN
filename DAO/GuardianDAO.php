<?php

namespace DAO;

use DAO\IDAO as IDAO;
use Exception;
use Models\Guardian as Guardian;

class GuardianDAO implements IDAO
{
    private $tableName;
    private $connection;

    function __construct()
    {
        $this->tableName = 'guardians';
    }

    /**
     * ADD
     */

    public function Add($guardian)
    {
        $query = "INSERT INTO " . $this->tableName . "(salaryExpected, reputation, startDate, endDate, id_animal_size_expected, id_user) 
            VALUES (:salaryExpected, null, null, null, :id_animal_size_expected, :id)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $guardian->getId();
            $parameters['salaryExpected'] = $guardian->getSalaryExpected();
            $parameters['id_animal_size_expected'] = $guardian->getId_animal_size_expected();
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * GETS
     */

    public function getAll()
    {
        $query = "SELECT * FROM guardians G INNER JOIN users U ON U.id_user = G.id_user 
                    WHERE G.startDate IS NOT NULL AND G.endDate IS NOT NULL";

        try {
            $this->connection = Connection::GetInstance();
            $result = $this->connection->Execute($query);

            if (!empty($result)) {
                return $this->mapGuardians($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

    public function getGuardiansFilterByDates($startDate, $endDate)
    {
        $query = "SELECT * FROM guardians G INNER JOIN users U ON U.id_user = G.id_user 
                    WHERE G.startDate >= (:startDate) AND G.endDate <= (:endDate)";

        try {
            $this->connection = Connection::GetInstance();

            $parameters['startDate'] = $startDate;
            $parameters['endDate'] = $endDate;

            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $this->mapGuardians($result);
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

    public function findGuardianIdByUserId($id)
    {
        $query = "select g.id_guardian from users u
                  inner join guardians g on u.id_user = g.id_user
                  where u.id_user = (:id)";
        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $result[0]['id_guardian'];
            }
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    public function getAnimalSizeExpectedById($id)
    {
        $query = "select g.id_animal_size_expected from users u
                  inner join guardians g on u.id_user = g.id_user
                  where g.id_guardian = (:id)";
        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = $id;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $result[0]['id_animal_size_expected'];
            }
        } catch (Exception $e) {
            throw $e;
        }

        return null;
    }

    public function bringStartAndEndDates($id_guardian)
    {
        $query = "SELECT g.startDate, g.endDate from guardians G WHERE G.id_guardian = (:id_guardian)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_guardian'] = $id_guardian;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $this->mapStartAndEndDates($result);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    public function bringSalaryExpected($id_guardian, $id_reservation)
    {

        $query = "SELECT G.salaryExpected, R.startDate, R.endDate
                    FROM guardians G
                    INNER JOIN reservations R on G.id_guardian = R.id_guardian
                    WHERE G.id_guardian = (:id_guardian) AND R.id_reservation = (:id_reservation)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_guardian'] = $id_guardian;
            $parameters['id_reservation'] = $id_reservation;
            $result = $this->connection->Execute($query, $parameters);

            if (!empty($result)) {
                return $this->mapReservationData($result);
            }
        } catch (Exception $e) {
            throw $e;
        }
        return null;
    }

    /**
     * MAPS
     */

    private function mapGuardians($guardians)
    {
        return array_map(function ($p) {
            $guardian = new Guardian();
            $guardian->setId($p["id_user"]);
            $guardian->setIdGuardian($p["id_guardian"]);
            $guardian->setUsername($p["username"]);
            $guardian->setFirstName($p["firstName"]);
            $guardian->setLastName($p["lastName"]);
            $guardian->setSalaryExpected($p["salaryExpected"]);
            $guardian->setReputation($p["reputation"]);
            $guardian->setStartDate($p["startDate"]);
            $guardian->setEndDate($p["endDate"]);
            $guardian->setEmail($p["email"]);
            $guardian->setId_animal_size_expected($p['id_animal_size_expected']);

            return $guardian;
        }, $guardians);

    }

    public function mapReservationData($result)
    {
        $resp = array_map(function ($p) {
            $infoCoupon = ["salaryExpected" => $p["salaryExpected"], "startDate" => $p["startDate"], "endDate" => $p["endDate"]];

            return $infoCoupon;
        }, $result);

        return count($resp) > 1 ? $resp : $resp[0];
    }

    public function mapStartAndEndDates($result)
    {
        $resp = array_map(function ($p) {
            $dates = ["startDate" => $p["startDate"], "endDate" => $p["endDate"]];

            return $dates;
        }, $result);

        return count($resp) > 1 ? $resp : $resp[0];
    }

    /**
     * Update
     */

    public function updateWorkDates($id_guardian, $startDate, $endDate)
    {
        $query = "update guardians g
                    set g.startDate = :startDate,
                        g.endDate = :endDate
                    where g.id_guardian = :id_guardian";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_guardian'] = $id_guardian;
            $parameters['startDate'] = $startDate;
            $parameters['endDate'] = $endDate;
            return $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
    }


}
