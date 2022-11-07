<?php

namespace DAO;
use Exception;

class ReservationDAO
{
    private $tableName;
    private $connection;

    function __construct()
    {
        $this->tableName = 'reservations';
    }

    public function createReservation($reservation)
    {
        $query = "INSERT INTO " . $this->tableName . "(id_guardian, state, startDate, endDate, concluded) VALUES (:id_guardian, :state, :startDate, :endDate, :concluded)";

        echo '<pre>';
        var_dump($reservation->getIdGuardian());
        var_dump($reservation->getState());
        var_dump($reservation->getStartDate());
        var_dump($reservation->getEndDate());
        var_dump($reservation->getConcluded());
        var_dump($query);
        echo '</pre>';

        try {
            $this->connection = Connection::GetInstance();
            $parameters['id_guardian'] = $reservation->getIdGuardian();
            $parameters['state'] = $reservation->getState();
            $parameters['startDate'] = $reservation->getStartDate();
            $parameters['endDate'] = $reservation->getEndDate();
            $parameters['concluded'] = $reservation->getConcluded();
            $this->connection->ExecuteNonQuery($query, $parameters);
        } catch (Exception $e) {
            throw $e;
        }
    }
}