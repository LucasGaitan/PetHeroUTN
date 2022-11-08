<?php

namespace DAO;

use Exception;

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

    public function getReservationsByGuardianId($id_guardian)
    {
        $query = "SELECT concat(u.firstName, ' ', u.lastName) as owner, t.type, ab.breed, s.size, r.startDate, r.endDate, r.concluded, r.state from reservations r
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
        if(!empty($result))
            return $this->mapReservationsQuery($result);
        else
            return null;
    }

    public function mapReservationsQuery ($result)
    {
        return array_map(function ($p) {
            return ["ownerName" => $p["owner"],
                "animalType" => $p["type"],
                "animalBreed"=>$p["breed"],
                "animalSize"=>$p["size"],
                "startDate"=>$p["startDate"],
                "endDate"=>$p["endDate"],
                "reservationConcluded"=>$p["concluded"],
                "reservationState"=>$p["state"]
            ];
        }, $result);
    }
}