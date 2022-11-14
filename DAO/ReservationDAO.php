<?php

namespace DAO;

use Exception;
use Models\Guardian as Guardian;

class ReservationDAO implements IDAO
{
    private $tableName;
    private $connection;

    function __construct()
    {
        $this->tableName = 'reservations';
    }

    public function add($reservation_animals)
    {

        $query = "CALL createReservation(:id_guardian, :state, :startDate, :endDate, :concluded, :id_animal)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_guardian'] = $reservation_animals["reservation"]->getIdGuardian();
            $parameters['state'] = $reservation_animals["reservation"]->getState();
            $parameters['startDate'] = $reservation_animals["reservation"]->getStartDate();
            $parameters['endDate'] = $reservation_animals["reservation"]->getEndDate();
            $parameters['concluded'] = $reservation_animals["reservation"]->getConcluded();
            $parameters['id_animal'] = $reservation_animals["id_animal"];
            $this->connection->ExecuteNonQuery($query, $parameters);


        } catch (Exception $e) {
            throw $e;
        }
    }

    public function updateState($idReservation)
    {

        $query = "update reservations r
set r.state = 1
where r.id_reservation = (:id)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id'] = (int)$idReservation;
            return $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function createCoupon($idReservation, $salaryExpected)
    {
        $query = "INSERT INTO paymentcoupons(id_reservation, payment) VALUES (:id_reservation, :halfpayment)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_reservation'] = (int)$idReservation;
            $parameters['halfpayment'] = ($salaryExpected/2);
            return $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getReservationsByGuardianId($id_guardian)
    {
        $query = "SELECT r.id_reservation, concat(u.firstName, ' ', u.lastName) as owner, t.type, ab.breed, s.size, r.startDate, r.endDate, r.concluded, r.state from reservations r
inner join guardians g on r.id_guardian = g.id_guardian
inner join reservations_X_animals rXa on r.id_reservation = rXa.id_reservation
inner join animals a on rXa.id_animal = a.id_animal
inner join owners o on a.id_owner = o.id_owner
inner join users u on o.id_user = u.id_user
inner join animal_breeds ab on a.id_animal_breed = ab.id_animal_breed
inner join animal_sizes s on a.id_animal_size = s.id_animal_size
inner join animal_types t on ab.id_animal_type = t.id_animal_type
where g.id_guardian = (:id_guardian)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_guardian'] = $id_guardian;
            $result = $this->connection->Execute($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
        if (!empty($result))
            return $this->mapReservationsQuery($result);
        else
            return null;
    }

    public function mapReservationsQuery($result)
    {
        return array_map(function ($p) {
            return ["id_reservation" => $p["id_reservation"],
                "ownerName" => $p["owner"],
                "animalType" => $p["type"],
                "animalBreed" => $p["breed"],
                "animalSize" => $p["size"],
                "startDate" => $p["startDate"],
                "endDate" => $p["endDate"],
                "reservationConcluded" => $p["concluded"],
                "reservationState" => $p["state"]
            ];
        }, $result);
    }

    public function getConfirmedReservationsByGuardian($id_owner)
    {
        $query = "SELECT *
                    FROM reservations r
                        INNER JOIN reservations_x_animals rxa on r.id_reservation = rxa.id_reservation
                        INNER JOIN animals a on rxa.id_animal = a.id_animal
                        INNER JOIN owners o on a.id_owner = o.id_owner
                        INNER JOIN guardians g on r.id_guardian = g.id_guardian
                        INNER JOIN users u on g.id_user = u.id_user
                        INNER JOIN paymentcoupons PC on PC.id_reservation = r.id_reservation
                    WHERE a.id_owner = (:id_owner) AND r.state = 1";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_owner'] = $id_owner;
            $result = $this->connection->Execute($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
        if (!empty($result))
            return $this->mapConfirmedReservationsQuery($result);
        else
            return null;
    }

//    public function mapConfirmedReservationsQuery($result)
//    {
//        $resp = array_map(function($p)
//        {
//            $guardian = new Guardian();
//            $guardian->setId($p["id_user"]);
//            $guardian->setIdGuardian($p["id_guardian"]);
//            $guardian->setUsername($p["username"]);
//            $guardian->setFirstName($p["firstName"]);
//            $guardian->setLastName($p["lastName"]);
//            $guardian->setSalaryExpected($p["salaryExpected"]);
//            $guardian->setReputation($p["reputation"]);
//            $guardian->setStartDate($p["startDate"]);
//            $guardian->setEndDate($p["endDate"]);
//            $guardian->setEmail($p["email"]);
//            $guardian->setId_animal_size_expected($p['id_animal_size_expected']);
//
//            return $guardian;
//        }, $result);
//
//        return $resp;
//    }

    public function mapConfirmedReservationsQuery($result)
    {
        $resp = array_map(function($p)
        {
            $infoCoupon = [
                "id_guardian"=>$p["id_guardian"],
                "firstName"=>$p["firstName"],
                "lastName"=>$p["lastName"],
                "startDate"=>$p["startDate"],
                "endDate"=>$p["endDate"],
                "payment"=>$p["payment"]];

            return $infoCoupon;
        }, $result);

        return $resp;
    }
}