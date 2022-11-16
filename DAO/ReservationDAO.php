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

    /**
     * ADD
     */

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
            return $this->connection->ExecuteNonQuery($query, $parameters);


        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * GETS
     */

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

    public function getReservationById($id_reservation)
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
where r.id_reservation = (:id_reservation)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_reservation'] = $id_reservation;
            $result = $this->connection->Execute($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
        if (!empty($result))
            return $this->mapReservationsQuery($result);
        else
            return null;
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
                        INNER JOIN paymentcoupons PC on PC.id_coupon = r.id_coupon
                    WHERE a.id_owner = (:id_owner) AND r.state = 1 AND r.concluded = 0";

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

    /**
     * MAPS
     */

    public function mapReservationsQuery($result)
    {
        $resp = array_map(function ($p) {
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
        return count($resp) > 1 ? $resp : $resp[0];
    }


    public function mapConfirmedReservationsQuery($result)
    {
        $resp = array_map(function($p)
        {
            $infoCoupon = [
                "id_guardian"=>$p["id_guardian"],
                "id_reservation"=>$p["id_reservation"],
                "firstName"=>$p["firstName"],
                "lastName"=>$p["lastName"],
                "startDate"=>$p["startDate"],
                "endDate"=>$p["endDate"],
                "payment"=>$p["payment"]];

            return $infoCoupon;
        }, $result);

        return $resp;
    }


    /**
     * UPDATE
     */

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

    public function createCoupon($idReservation, $salaryExpected): int
    {
        $query = "CALL createCoupon(:id_reservation, :payment)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_reservation'] = (int)$idReservation;
            $parameters['payment'] = ($salaryExpected / 2);
            return $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getConfirmedReservationsByGuardianForConcluded($id_owner)
    {
        $query = "SELECT *
                    FROM reservations r
                        INNER JOIN reservations_x_animals rxa on r.id_reservation = rxa.id_reservation
                        INNER JOIN animals a on rxa.id_animal = a.id_animal
                        INNER JOIN owners o on a.id_owner = o.id_owner
                        INNER JOIN guardians g on r.id_guardian = g.id_guardian
                        INNER JOIN users u on g.id_user = u.id_user
                        INNER JOIN paymentcoupons PC on PC.id_coupon = r.id_coupon
                    WHERE a.id_owner = (:id_owner) AND r.state = 1 AND r.concluded = 1";
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

    public function concludeReserve($idReservation)
    {
        $query = "UPDATE reservations R SET R.concluded = 1 WHERE R.id_reservation = (:id_reservation)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_reservation'] = (int)$idReservation;
            return $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function finishedReserved($idReservation)
    {
        $query = "CALL finishedReservationAndDeleteACoupon(:id_reservation)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_reservation'] = (int)$idReservation;
            return $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
    }

    public function getGuardianIdByReservation($idReservation)
    {
        $query = "SELECT R.id_guardian FROM reservations R WHERE R.id_reservation = (:id_reservation);";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_reservation'] = $idReservation;
            $result = $this->connection->Execute($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
        if (!empty($result))
            return $result;
        else
            return null;
    }

    public function getConfirmedReservationsByGuardianForReview($id_owner)
    {
        $query = "SELECT *
                    FROM reservations r
                        INNER JOIN reservations_x_animals rxa on r.id_reservation = rxa.id_reservation
                        INNER JOIN animals a on rxa.id_animal = a.id_animal
                        INNER JOIN owners o on a.id_owner = o.id_owner
                        INNER JOIN guardians g on r.id_guardian = g.id_guardian
                        INNER JOIN users u on g.id_user = u.id_user
                    WHERE a.id_owner = (:id_owner) AND r.state = 1 AND r.concluded = 1 AND r.id_coupon IS NULL";
        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_owner'] = $id_owner;
            $result = $this->connection->Execute($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
        if (!empty($result))
            return $this->mapConfirmedReservationsForReviewQuery($result);
        else
            return null;
    }

    public function mapConfirmedReservationsForReviewQuery($result)
    {
        $resp = array_map(function($p)
        {
            $infoCoupon = [
                "id_guardian"=>$p["id_guardian"],
                "id_reservation"=>$p["id_reservation"],
                "firstName"=>$p["firstName"],
                "lastName"=>$p["lastName"],
                "startDate"=>$p["startDate"],
                "endDate"=>$p["endDate"]];

            return $infoCoupon;
        }, $result);

        return $resp;
    }

    public function finishedReservedForReview($comment, $stars, $id_owner, $id_guardian)
    {
        $query = "INSERT INTO reviewservices(comment, stars, id_owner, id_guardian) VALUES (:comment, :stars, :id_owner, :id_guardian)";

        try {
            $this->connection = Connection::GetInstance();
            $parameters['comment'] = $comment;
            $parameters['stars'] = (int)$stars;
            $parameters['id_owner'] = (int)$id_owner;
            $parameters['id_guardian'] = (int)$id_guardian;
            return $this->connection->ExecuteNonQuery($query, $parameters);

        } catch (Exception $e) {
            throw $e;
        }
    }
}