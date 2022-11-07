<?php
    namespace DAO;

    use DAO\IDAO as IDAO;
    use Models\Guardian as Guardian;

    class GuardianDAO implements IDAO
    {
        private $tableName;
        private $connection;

        function __construct()
        {
            $this->tableName = 'guardians';
        }

        public function Add($guardian)
        {
            $query = "INSERT INTO " . $this->tableName . "(salaryExpected, reputation, startDate, endDate, id_animal_size_expected, id_user) 
            VALUES (:salaryExpected, null, null, null, :id_animal_size_expected, :id)";

            try
            {
                $this->connection = Connection::GetInstance();
                $parameters['id'] = $guardian->getId();
                $parameters['salaryExpected'] = $guardian->getSalaryExpected();
                $parameters['id_animal_size_expected'] = $guardian->getId_animal_size_expected();
                $this->connection->ExecuteNonQuery($query, $parameters);
            }
            catch(Exception $e)
            {
                throw $e;
            }
        }

        private function mapGuardians($guardians)
        {
            $resp = array_map(function($p)
            {
                $guardian = new Guardian();
                $guardian->setId($p["id_user"]);
                $guardian->setIdGuardian($p["id_guardian"]);
                $guardian->setUsername($p["username"]);
                $guardian->setFirstName($p["firstName"]);
                $guardian->setLastName($p["lastName"]);
                $guardian->setSalaryExpected($p["salaryExpected"]);
                $guardian->setReputation($p["reputation"]);
                $guardian->setStarDate($p["startDate"]);
                $guardian->setEndDate($p["endDate"]);
                $guardian->setEmail($p["email"]);
                $guardian->setId_animal_size_expected($p['id_animal_size_expected']);

                return $guardian;
            }, $guardians);

            return $resp;
        }

        public function getAll()
        {
            $query = "SELECT * FROM guardians G INNER JOIN users U ON U.id_user = G.id_user";
            $listGuardians = array();

            try
            {
                $this->connection = Connection::GetInstance();
                $result = $this->connection->Execute($query);

                if(!empty($result))
                {
                    $listGuardians = $this->mapGuardians($result);
                }
            }
            catch(Exception $e)
            {
                throw $e;
            }

            return $listGuardians;
        }

        public function getGuardiansFilterByDates($startDate, $endDate)
        {
            $query = "SELECT * FROM guardians G INNER JOIN users U ON U.id_user = G.id_user 
                    WHERE G.startDate <= (:startDate) AND G.endDate >= (:endDate)";

            $listGuardians = array();

            try
            {
                $this->connection = Connection::GetInstance();

                $parameters['startDate'] = $startDate;
                $parameters['endDate'] = $endDate;

                $result = $this->connection->Execute($query, $parameters);

                if(!empty($result))
                {
                    $listGuardians = $this->mapGuardians($result);
                }
            }
            catch(Exception $e)
            {
                throw $e;
            }

            return $listGuardians;
        }
    }
